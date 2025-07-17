<?php
session_start();
require '../database/config.php';

if (isset($_GET['date'])) {
    $attendanceDate = mysqli_real_escape_string($conn, $_GET['date']);
    
    // Delete attendance records for the selected date
    $query = "DELETE FROM attendance_record WHERE date = '$attendanceDate'";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Attendance records for $attendanceDate have been deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting attendance records.";
    }
    
    header('Location: index.php');
    exit();
} else {
    $_SESSION['message'] = "Invalid date.";
    header('Location: index.php');
    exit();
}
?>
