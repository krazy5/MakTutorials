<?php
session_start();
require '../database/config.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $attendanceDate = isset($_POST['attendance_date']) ? $_POST['attendance_date'] : '';
    $statusData = isset($_POST['status']) ? $_POST['status'] : [];
    $customStatusData = isset($_POST['custom_status']) ? $_POST['custom_status'] : [];

    // Function to validate date format and check if it's a valid calendar date
    function isValidDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    // Ensure a valid attendance date is selected
    if (empty($attendanceDate) || !isValidDate($attendanceDate)) {
        $_SESSION['message'] = 'Please select a valid attendance date.';
        header('Location: index.php');
        exit();
    }

    // Validate the date: ensure it's not in the future
    $today = date('Y-m-d');
    if ($attendanceDate > $today) {
        $_SESSION['message'] = 'Invalid date. You cannot mark attendance for a future date.';
        header('Location: index.php');
        exit();
    }

    // Loop through each student's attendance status
    foreach ($statusData as $studentId => $status) {
        // If "Other" is selected and custom status is provided, use custom status
    if ($status === 'Other' && !empty($customStatusData[$studentId])) {
        $status = mysqli_real_escape_string($conn, $customStatusData[$studentId]);
    } elseif ($status === 'Other' && empty($customStatusData[$studentId])) {
        $status = 'Other';  // Fallback to "Other" if no custom status is entered
    } else {
        $status = mysqli_real_escape_string($conn, $status);
    }

        // Check if an attendance record already exists for the student and date
        $stmt = mysqli_prepare($conn, "SELECT id FROM attendance_record WHERE student_id = ? AND date = ?");
        mysqli_stmt_bind_param($stmt, 'is', $studentId, $attendanceDate);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Update the existing attendance record with the new status
            $updateStmt = mysqli_prepare($conn, "UPDATE attendance_record SET status = ? WHERE student_id = ? AND date = ?");
            mysqli_stmt_bind_param($updateStmt, 'sis', $status, $studentId, $attendanceDate);
            if (!mysqli_stmt_execute($updateStmt)) {
                $_SESSION['message'] = 'Error updating attendance for student ID ' . $studentId;
                header('Location: index.php');
                exit();
            }
        } else {
            // Insert a new attendance record if none exists
            $insertStmt = mysqli_prepare($conn, "INSERT INTO attendance_record (student_id, date, status) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insertStmt, 'iss', $studentId, $attendanceDate, $status);
            if (!mysqli_stmt_execute($insertStmt)) {
                $_SESSION['message'] = 'Error inserting attendance for student ID ' . $studentId;
                header('Location: index.php');
                exit();
            }
        }

        // Close the statement to free resources
        mysqli_stmt_close($stmt);
    }

    // Close the database connection
    mysqli_close($conn);

    // Set success message and redirect back to index page
    $_SESSION['message'] = 'Attendance has been successfully saved or updated for all students.';
    
	echo "<script>
    window.history.back(); // This will take the user back to the previous page
    window.close(); // Attempt to close the tab
</script>";
    exit();
} else {
    // If the request method is invalid
    $_SESSION['message'] = 'Invalid request method.';
    
	echo "<script>
    window.history.back(); // This will take the user back to the previous page
    window.close(); // Attempt to close the tab
</script>";
    exit();
}
