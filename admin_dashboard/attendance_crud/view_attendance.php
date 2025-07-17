<?php

require '../database/config.php';

$attendanceDate = isset($_GET['date']) ? $_GET['date'] : '';
$today = date('Y-m-d');

// Fetch students and their attendance for the selected date
$attendanceQuery = "SELECT student_record.student_id, CONCAT(student_record.first_name, ' ', student_record.last_name) AS full_name, attendance_record.status 
                    FROM attendance_record
                    JOIN student_record ON attendance_record.student_id = student_record.student_id
                    WHERE attendance_record.date = '$attendanceDate'";
$attendanceResult = mysqli_query($conn, $attendanceQuery);
$attendanceData = mysqli_fetch_all($attendanceResult, MYSQLI_ASSOC);

// Fetch attendance count for the current month
$month = date('m', strtotime($attendanceDate));
$year = date('Y', strtotime($attendanceDate));

$monthlyAttendanceQuery = "SELECT student_record.student_id, CONCAT(student_record.first_name, ' ', student_record.last_name) AS full_name, 
                            SUM(CASE WHEN attendance_record.status = 'Present' THEN 1 ELSE 0 END) AS present_count,
                            SUM(CASE WHEN attendance_record.status = 'Absent' THEN 1 ELSE 0 END) AS absent_count,
                            SUM(CASE WHEN attendance_record.status = 'Late' THEN 1 ELSE 0 END) AS late_count,
                            SUM(CASE WHEN attendance_record.status = 'Holiday' THEN 1 ELSE 0 END) AS holiday_count,
                            SUM(CASE WHEN attendance_record.status NOT IN ('Present', 'Absent', 'Late', 'Holiday') THEN 1 ELSE 0 END) AS other_count
                            FROM attendance_record
                            JOIN student_record ON attendance_record.student_id = student_record.student_id
                            WHERE MONTH(attendance_record.date) = '$month' AND YEAR(attendance_record.date) = '$year'
                            GROUP BY student_record.student_id";

$monthlyAttendanceResult = mysqli_query($conn, $monthlyAttendanceQuery);
$monthlyAttendanceData = mysqli_fetch_all($monthlyAttendanceResult, MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>View Attendance</title>
    <style>
        .fix {
            position: sticky;
            background: white;
        }
        .fix:first-child {
            left:0;
            width:180px;
            background-color: #D6EEEE;
        }
        .fix:last-child {
            right:0;
            width:160px;
            background-color: #D6EEEE;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
    </style>
</head>
<body>
     <!-- Navigation Bar -->
        <?php include '../navigation_menu/navigation.php' ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Attendance for <?= htmlspecialchars($attendanceDate); ?></h4>
                    <a href="javascript:void(0);"  class="btn btn-secondary" onclick="goBack()">Back</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($attendanceData)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($attendanceData as $record): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($record['full_name']); ?></td>
                                            <td><?= htmlspecialchars($record['status']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">No attendance records found for this date.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Monthly Attendance Summary for <?= date('F Y', strtotime($attendanceDate)); ?></h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($monthlyAttendanceData)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Present Count</th>
                                        <th>Absent Count</th>
                                        <th>Late Count</th>
                                        <th>Holiday Count</th>
                                        <th>Other Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($monthlyAttendanceData as $record): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($record['full_name']); ?></td>
                                            <td><?= htmlspecialchars($record['present_count']); ?></td>
                                            <td><?= htmlspecialchars($record['absent_count']); ?></td>
                                            <td><?= htmlspecialchars($record['late_count']); ?></td>
                                            <td><?= htmlspecialchars($record['holiday_count']); ?></td>
                                            <td><?= htmlspecialchars($record['other_count']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">No monthly attendance records available.</div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
 function goBack() {
        // Redirect to index.php
        window.open('index.php', '_self');
        // Close the current tab
        window.close();
    }
</script>
</body>
</html>
