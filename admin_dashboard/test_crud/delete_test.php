<?php
session_start();
require '../database/config.php';

if (isset($_GET['test_id'])) {
    $test_id = intval($_GET['test_id']);  // Sanitize input

    // First, fetch the file path of the image associated with this test record
    $fetch_file_query = $conn->prepare("SELECT test_file FROM student_tests WHERE test_id = ?");
    $fetch_file_query->bind_param("i", $test_id);
    $fetch_file_query->execute();
    $result = $fetch_file_query->get_result();
    $test_data = $result->fetch_assoc();
    $file_path = $test_data['test_file'];

    // Check if the file exists and delete it
    if (!empty($file_path) && file_exists($file_path)) {
        if (!unlink($file_path)) {
            $_SESSION['message'] = "Failed to delete the test file.";
            $_SESSION['message_type'] = 'danger'; // Set message type for Bootstrap alert
            header("Location: index.php");  // Redirect back to the index page
            exit();
        }
    }

    $fetch_file_query->close();

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM student_tests WHERE test_id = ?");
    $stmt->bind_param("i", $test_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Test record and file deleted successfully.";
        $_SESSION['message_type'] = 'success'; // Set message type for Bootstrap alert
    } else {
        $_SESSION['message'] = "Failed to delete the test record.";
        $_SESSION['message_type'] = 'danger'; // Set message type for Bootstrap alert
    }

    $stmt->close();
    $conn->close();

    header("Location: index.php");  // Redirect back to the index page
    exit();
} else {
    $_SESSION['message'] = "No test record ID provided.";
    $_SESSION['message_type'] = 'danger'; // Set message type for Bootstrap alert
    header("Location: index.php");  // Redirect back to the index page
    exit();
}
