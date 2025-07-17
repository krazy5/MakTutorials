<?php
session_start();
require "../database/config.php"; // Ensure this path is correct and that config.php contains correct DB credentials

// Function to handle error logging (optional)
function logError($message) {
    error_log($message, 3, 'error_log.log'); // Log errors to a file for debugging purposes
}

// Handle Delete Enquiry --------------------------------------------------
if (isset($_POST['delete_enquiry'])) {
    $enquiry_id = mysqli_real_escape_string($conn, $_POST['delete_enquiry']);
    
    // Delete the enquiry from the database
    $delete_query = "DELETE FROM enquiry WHERE enquiry_id='$enquiry_id'";
    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        $_SESSION['message'] = "Enquiry deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete enquiry.";
        logError("Delete Enquiry Error: " . mysqli_error($conn));
    }

    header("Location: index.php");
    exit(0);
}

// Handle Update Enquiry --------------------------------------------------
if (isset($_POST['update_enquiry'])) {
    $enquiry_id = mysqli_real_escape_string($conn, $_POST['enquiry_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course_interested = mysqli_real_escape_string($conn, $_POST['course_interested']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $fees_offered = mysqli_real_escape_string($conn, $_POST['fees_offered']);
    $remark = mysqli_real_escape_string($conn, $_POST['remark']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Ensure required fields are filled
    if (empty($full_name) || empty($contact_number) || empty($course_interested) || empty($status)) {
        $_SESSION['message'] = "Please fill in all required fields.";
        header("Location: edit.php?id=$enquiry_id");
        exit(0);
    }

    $update_query = "UPDATE enquiry 
                     SET full_name='$full_name', 
                         contact_number='$contact_number', 
                         email='$email', 
                         course_interested='$course_interested', 
                         location='$location',
                         fees_offered='$fees_offered', 
                         remark='$remark', 
                         status='$status', 
                         updated_at=NOW() 
                     WHERE enquiry_id='$enquiry_id'";

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['message'] = "Enquiry updated successfully";
    } else {
        $_SESSION['message'] = "Enquiry update failed";
        logError("Update Enquiry Error: " . mysqli_error($conn));
    }

    header("Location: edit.php?id=$enquiry_id");
    exit(0);
}

// Handle Insert New Enquiry --------------------------------------------------
if (isset($_POST['save_enquiry'])) {
    // Get form data
    $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $courseInterested = mysqli_real_escape_string($conn, $_POST['course_interested']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $feesOffered = mysqli_real_escape_string($conn, $_POST['fees_offered']);
    $remark = mysqli_real_escape_string($conn, $_POST['remark']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Check required fields
    if (empty($fullName) || empty($contactNumber) || empty($courseInterested) || empty($status)) {
        $_SESSION['message'] = "Please fill in all required fields.";
        header("Location: create.php");
        exit(0);
    }

    // Insert query
    $insert_query = "INSERT INTO enquiry (full_name, contact_number, email, course_interested, location, fees_offered, remark, enquiry_date, status) 
                     VALUES ('$fullName', '$contactNumber', '$email', '$courseInterested', '$location', '$feesOffered', '$remark', CURRENT_DATE, '$status')";

    // Execute the query and check for errors
    if (mysqli_query($conn, $insert_query)) {
        $_SESSION['message'] = "Enquiry submitted successfully!";
    } else {
        $_SESSION['message'] = "Database error: Could not submit enquiry.";
        logError("Insert Enquiry Error: " . mysqli_error($conn));
    }

    header("Location: create.php");
    exit(0);
}
?>
