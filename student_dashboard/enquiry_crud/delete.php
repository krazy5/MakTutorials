<?php
session_start();
require 'db_connect.php';

if (isset($_POST['delete_enquiry'])) {
    $enquiry_id = mysqli_real_escape_string($conn, $_POST['delete_enquiry']);
    
    // Delete the enquiry from the database
    $delete_query = "DELETE FROM enquiry WHERE enquiry_id='$enquiry_id'";
    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        $_SESSION['message'] = "Enquiry deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete enquiry.";
    }

    header("Location: index.php");
    exit(0);
} else {
    $_SESSION['message'] = "No enquiry ID specified.";
    header("Location: index.php");
    exit(0);
}
?>
