<?php
require '../database/config.php';

$date = $_GET['date'];
$query = "SELECT * FROM attendance_record WHERE date = '$date'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo 'exists';
} else {
    echo 'not_exists';
}
?>
