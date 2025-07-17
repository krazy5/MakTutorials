<?php
require '../database/config.php';

$attendanceDate = isset($_GET['date']) ? $_GET['date'] : '';
$today = date('Y-m-d');

// Fetch all students
$studentsQuery = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS full_name FROM student_record";
$studentsResult = mysqli_query($conn, $studentsQuery);
$students = mysqli_fetch_all($studentsResult, MYSQLI_ASSOC);

// Fetch attendance records
if ($attendanceDate) {
    if ($attendanceDate > $today || !$attendanceDate) {
        $_SESSION['message'] = 'Invalid date. Please select today or a past date.';
        header('Location: index.php');
        exit();
    }

    // Fetch attendance records for the selected date
    $query = "SELECT attendance_record.date, student_record.student_id, CONCAT(student_record.first_name, ' ', student_record.last_name) AS full_name, attendance_record.status 
              FROM attendance_record
              JOIN student_record ON attendance_record.student_id = student_record.student_id
              WHERE attendance_record.date = '$attendanceDate'";
    $attendanceResult = mysqli_query($conn, $query);
    $attendanceData = mysqli_fetch_all($attendanceResult, MYSQLI_ASSOC);
    
    if (empty($attendanceData)) {
        $noRecordMessage = "No Record Found";
    }
} else {
    // Fetch all attendance records grouped by date in descending order
    $query = "SELECT attendance_record.date, student_record.student_id, CONCAT(student_record.first_name, ' ', last_name) AS full_name, attendance_record.status 
              FROM attendance_record
              JOIN student_record ON attendance_record.student_id = student_record.student_id
              ORDER BY attendance_record.date DESC";
    $attendanceResult = mysqli_query($conn, $query);
    $attendanceData = mysqli_fetch_all($attendanceResult, MYSQLI_ASSOC);
}

// Group attendance data by date
$attendanceByDate = [];
if (!empty($attendanceData)) {
    foreach ($attendanceData as $record) {
        $attendanceByDate[$record['date']][] = $record;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Attendance Details</title>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <input type="date" id="attendance-date" class="form-control me-2" style="width: 200px;" onchange="filterByDate()" value="<?= htmlspecialchars($attendanceDate) ?>">
                        <a href="add_attendance.php" class="btn btn-success" target="_blank">Add Attendance</a>
                    </div>
                </div>
            </div>

            <?php if (!empty($attendanceDate) && isset($noRecordMessage)): ?>
                <div class="alert alert-warning text-center"><?= $noRecordMessage; ?></div>
            <?php endif; ?>

            <?php if (!empty($attendanceByDate)): ?>
                <div id="accordion">
                    <?php foreach ($attendanceByDate as $date => $records): ?>
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <a class="btn" data-bs-toggle="collapse" href="#collapse<?= htmlspecialchars($date); ?>">
                                    Attendance for <?= htmlspecialchars($date); ?>
                                </a>
                                <div>
                                    <a href="add_attendance.php?date=<?= htmlspecialchars($date); ?>" class="btn btn-warning btn-sm" target="_blank">Update</a>
                                    <a href="view_attendance.php?date=<?= htmlspecialchars($date); ?>" class="btn btn-info btn-sm" target="_blank">View</a>
                                    <a href="delete_attendance.php?date=<?= htmlspecialchars($date); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete the attendance for <?= htmlspecialchars($date); ?>?');">Delete</a>
                                </div>
                            </div>
                            <div id="collapse<?= htmlspecialchars($date); ?>" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($records as $record): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($record['full_name']); ?></td>
                                                        <td><?= htmlspecialchars($record['status']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">No attendance records available.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function filterByDate() {
        const selectedDate = document.getElementById('attendance-date').value;
        if (!selectedDate || selectedDate > new Date().toISOString().split('T')[0]) {
            alert('Please select a valid date (today or earlier).');
            document.getElementById('attendance-date').value = '';
            return;
        }

        window.location.href = `index.php?date=${selectedDate}`;
    }
	document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'visible') {
        location.reload();
    }
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
