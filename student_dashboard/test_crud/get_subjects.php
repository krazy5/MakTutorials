<?php
require '../database/config.php';

if (isset($_GET['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

    // Fetch unique subjects for the selected student
    $subjects_query = "SELECT DISTINCT subject FROM student_tests WHERE student_id = '$student_id'";
    $subjects_result = mysqli_query($conn, $subjects_query);

    $subjects = [];
    while ($row = mysqli_fetch_assoc($subjects_result)) {
        $subjects[] = $row;
    }

    echo json_encode($subjects);
}
?>
