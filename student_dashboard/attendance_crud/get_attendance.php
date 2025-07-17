<?php
require '../database/config.php';

if (isset($_GET['date'])) {
    $date = mysqli_real_escape_string($conn, $_GET['date']);

    $query = "SELECT student_id, status FROM attendance_record WHERE date = '$date'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $attendanceData = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $studentsQuery = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS full_name FROM student_record";
        $studentsResult = mysqli_query($conn, $studentsQuery);
        $students = mysqli_fetch_all($studentsResult, MYSQLI_ASSOC);

        $attendanceTableRows = '';
        foreach ($students as $student) {
            $status = array_filter($attendanceData, function($record) use ($student) {
                return $record['student_id'] == $student['student_id'];
            });

            $status = !empty($status) ? reset($status)['status'] : '';
            $attendanceTableRows .= '<tr>';
            $attendanceTableRows .= '<td class="fix">' . htmlspecialchars($student['full_name']) . '</td>';
            $attendanceTableRows .= '<td>' . htmlspecialchars($status) . '</td>';
            $attendanceTableRows .= '</tr>';
        }

        echo $attendanceTableRows;
    } else {
        echo '<tr><td colspan="2">No Record Found</td></tr>';
    }
} else {
    echo '<tr><td colspan="2">Invalid Date</td></tr>';
}
?>
