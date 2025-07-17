<?php
session_start();
require "../database/config.php";

//Save test from here-----------------------------------------------



if (isset($_POST['save_test'])) {
    // Assuming $conn is your database connection

     // Get form data
    
    $studentId = mysqli_real_escape_string($conn, $_POST['student_id']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $marksObtained = mysqli_real_escape_string($conn, $_POST['marks_obtained']);
    $totalMarks = mysqli_real_escape_string($conn, $_POST['total_marks']);
    $testDate = mysqli_real_escape_string($conn, $_POST['test_date']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    
        // Server-side validation to check if marks obtained are greater than total marks
        if ($marksObtained > $totalMarks) {
            $_SESSION['message'] = "Marks obtained cannot be greater than total marks.";
            header("Location: add_test.php");
            exit(0);
        }

    // Calculate percentage
    $percentage = ($marksObtained / $totalMarks) * 100;

    // Calculate is_passed and grade
    $isPassed = ($percentage >= 35) ? 1 : 0; // Pass percentage is now 35%
    $grade = '';

        // Updated grade calculation logic
        if ($percentage >= 80) {
            $grade = 'A';
        } elseif ($percentage >= 70) {
            $grade = 'B';
        } elseif ($percentage >= 60) {
            $grade = 'C';
        } elseif ($percentage >= 50) {
            $grade = 'D';
        } elseif ($percentage >= 35) {
            $grade = 'E';
        } else {
            $grade = 'F';
        }

        // Validation: Prevent future test dates
        if ($testDate > date('Y-m-d')) {
            $_SESSION['message'] = "Test date cannot be in the future.";
            header("Location: add_test.php");
            exit(0);
        }

        $target_file = null; // Set default for the file upload as optional

        // Handle file upload if exists
        if (!empty($_FILES["attachment"]["name"])) {
            $target_dir = "uploads/";

            // Generate a unique file name using the current timestamp and a unique ID
            $fileName = uniqid() . '_' . time();
            
            // Sanitize the filename
            $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $fileName);  // Replace invalid characters with underscores
            
            // Get file extension
            $fileType = strtolower(pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION));
            $target_file = $target_dir . $fileName . '.' . $fileType;

            // Check if a file with the same name already exists in the uploads directory (highly unlikely with the unique filename)
            if (file_exists($target_file)) {
                $_SESSION['message'] = "A record with the same file name already exists. This record already exists.";
                header("Location: add_test.php");
                exit(0);
            }

            // Validation: Check if file is a valid format
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
            if (!in_array($fileType, $allowed_types)) {
                $_SESSION['message'] = "Only JPG, JPEG, PNG, GIF, & PDF files are allowed.";
                header("Location: add_test.php");
                exit(0);
            }

            // Limit file size (e.g., 2MB max)
            if ($_FILES["attachment"]["size"] > 2000000) {
                $_SESSION['message'] = "Sorry, your file is too large. Max 2MB allowed.";
                header("Location: add_test.php");
                exit(0);
            }

            // If validation passes, move the file
            if (!move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
                $_SESSION['message'] = "Sorry, there was an error uploading the file.";
                header("Location: add_test.php");
                exit(0);
            }
        }

    // Insert data into the database (including the percentage)
    $query = "INSERT INTO student_tests (student_id, subject, marks_obtained, total_marks, percentage, test_date, remarks, test_file, is_passed, grade) 
              VALUES ('$studentId', '$subject', '$marksObtained', '$totalMarks', '$percentage', '$testDate', '$remarks', '$target_file', '$isPassed', '$grade')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Test record added successfully!";
        header("Location: add_test.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Database error: Could not insert record.";
        header("Location: add_test.php");
        exit(0);
    }
    header("Location: add_test.php");
    exit(0);
}







if (isset($_POST['delete_test'])) {
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
}


?>