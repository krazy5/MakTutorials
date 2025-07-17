<?php
include "../database/config.php";

$student_id = $_GET['student_id'];

$query = "SELECT photo, CONCAT(first_name, ' ', last_name) AS name FROM student_record WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
    echo json_encode($student);
} else {
    echo json_encode(['photo' => '', 'name' => '']);
}
?>
