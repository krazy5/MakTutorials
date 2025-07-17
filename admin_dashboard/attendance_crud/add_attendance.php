<?php

require '../database/config.php';

$attendanceDate = isset($_GET['date']) ? $_GET['date'] : '';
$today = date('Y-m-d');

// Validate attendance date (must be today or past)
if ($attendanceDate && ($attendanceDate > $today || !$attendanceDate)) {
    $_SESSION['message'] = 'Invalid date. Please select today or a past date.';
    header('Location: index.php');
    exit();
}

$attendanceExists = false;
$attendanceData = [];
$students = [];

// Check if attendance exists for the selected date
if ($attendanceDate) {
    // Query to check if attendance records exist for this date
    $attendanceCheckQuery = "SELECT COUNT(*) as record_count FROM attendance_record WHERE date = '$attendanceDate'";
    $attendanceCheckResult = mysqli_query($conn, $attendanceCheckQuery);
    $attendanceCheckRow = mysqli_fetch_assoc($attendanceCheckResult);

    // If any records exist for the date, set $attendanceExists to true
    $attendanceExists = ($attendanceCheckRow['record_count'] > 0);

    // Fetch existing attendance data
    if ($attendanceExists) {
        $query = "SELECT student_id, status FROM attendance_record WHERE date = '$attendanceDate'";
        $result = mysqli_query($conn, $query);
        $attendanceData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Fetch students' names
    $studentsQuery = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS full_name FROM student_record order by first_name";
    $studentsResult = mysqli_query($conn, $studentsQuery);
    $students = mysqli_fetch_all($studentsResult, MYSQLI_ASSOC);
} else {
    // Fetch students' names if no date is provided
    $studentsQuery = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS full_name FROM student_record";
    $studentsResult = mysqli_query($conn, $studentsQuery);
    $students = mysqli_fetch_all($studentsResult, MYSQLI_ASSOC);
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Flatpickr CSS for calendar -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    <title><?= $attendanceExists ? 'Update Attendance' : 'Mark Attendance' ?></title>
    <style>
        .status-button {
            margin-right: 10px;
        }
        .status-input {
            display: none;
            margin-top: 10px;
        }
        /* Styled radio buttons */
        .status-radio input[type="radio"] {
            accent-color: #0d6efd;
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }

        /* Additional styling for custom status input */
        .custom-status-container {
            display: none;
        }

        /* Flatpickr calendar */
        .flatpickr-calendar {
            display: block;
            position: relative;
        }

        .calendar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .back-button {
            margin-bottom: 10px;
        }

        /* Beautify the radio buttons and container */
        .status-radio {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        /* Ensure radio buttons look more appealing */
        .radio-label {
            margin-right: 15px;
        }

        .table-responsive {
            overflow-x: auto;
            position: relative;
        }

        .table-responsive th.fix,
        .table-responsive td.fix {
            position: sticky;
            left: 0;
            z-index: 2;
            background-color: #fff;
        }

        th.fix {
            z-index: 3;
        }

        /* Highlight selected date in the calendar */
        .flatpickr-day.selected {
            background-color: lightblue !important;
            color: black !important;
        }
    </style>
</head>
<body>
     <!-- Navigation Bar -->
        <?php include '../navigation_menu/navigation.php' ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <?= $attendanceExists ? 'Update Attendance' : 'Mark Attendance' ?>
                        <div class="calendar-container">
                            <div id="inline-calendar" style="max-width: 400px;"></div>
                            <a href="javascript:void(0);" class="btn btn-secondary back-button" onclick="goBack()">Back</a>
                        </div>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5>Select Status for <?=$attendanceDate?>:</h5>
                        <button class="btn btn-primary status-button" onclick="setAllStatus('Present')">Present</button>
                        <button class="btn btn-danger status-button" onclick="setAllStatus('Absent')">Absent</button>
                        <button class="btn btn-warning status-button" onclick="setAllStatus('Late')">Late</button>
                        <button class="btn btn-info status-button" onclick="setAllStatus('Holiday')">Holiday</button>
                        <button class="btn btn-secondary status-button" onclick="setAllStatus('Other')">Other</button>
                    </div>

                    <form id="attendance-form" action="save_attendance.php" method="POST" onsubmit="return validateForm()">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="fix">Student Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <?php
                                        $status = array_filter($attendanceData, function($record) use ($student) {
                                            return $record['student_id'] == $student['student_id'];
                                        });

                                        $status = !empty($status) ? reset($status)['status'] : '';
                                        $customStatus = ($status === 'Other') ? reset($attendanceData)['status'] : '';
                                        ?>
                                        <tr>
                                            <td class="fix"><?= htmlspecialchars($student['full_name']); ?></td>
                                            <td>
                                                <div class="status-radio">
                                                    <label class="radio-label">
                                                        <input type="radio" name="status[<?= $student['student_id']; ?>]" value="Present" <?= $status === 'Present' ? 'checked' : '' ?>> Present
                                                    </label>
                                                    <label class="radio-label">
                                                        <input type="radio" name="status[<?= $student['student_id']; ?>]" value="Absent" <?= $status === 'Absent' ? 'checked' : '' ?>> Absent
                                                    </label>
                                                    <label class="radio-label">
                                                        <input type="radio" name="status[<?= $student['student_id']; ?>]" value="Late" <?= $status === 'Late' ? 'checked' : '' ?>> Late
                                                    </label>
                                                    <label class="radio-label">
                                                        <input type="radio" name="status[<?= $student['student_id']; ?>]" value="Holiday" <?= $status === 'Holiday' ? 'checked' : '' ?>> Holiday
                                                    </label>
                                                    <label class="radio-label">
                                                        <input type="radio" name="status[<?= $student['student_id']; ?>]" value="Other" <?= $status === 'Other' ? 'checked' : '' ?>> Other
                                                    </label>
                                                </div>
                                                <input type="text" name="custom_status[<?= $student['student_id']; ?>]" class="form-control status-input custom-status-container" placeholder="Enter custom status" value="<?= htmlspecialchars($customStatus) ?>" <?= $status === 'Other' ? 'style="display:block"' : 'style="display:none"' ?>>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" id="attendance-date" name="attendance_date" value="<?= htmlspecialchars($attendanceDate) ?>">
                        <button type="submit" class="btn btn-primary"><?= $attendanceExists ? 'Update Attendance' : 'Add Attendance' ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.querySelectorAll('input[name^="status"]').forEach(radio => {
    const customInput = radio.closest('td').querySelector('.status-input');
    if (radio.checked && radio.value === 'Other') {
        customInput.style.display = 'block';
    }

    radio.addEventListener('change', function() {
        if (this.value === 'Other') {
            customInput.style.display = 'block';
        } else {
            customInput.style.display = 'none';
        }
    });
});

flatpickr("#inline-calendar", {
    inline: true,
    maxDate: "today",  // Disable future dates
    defaultDate: "<?= $attendanceDate ?>",  // Set to selected date
    onChange: function(selectedDates, dateStr) {
        window.location.href = `add_attendance.php?date=${dateStr}`;
    }
});

function validateForm() {
    const attendanceDate = document.getElementById('attendance-date').value;
    if (!attendanceDate) {
        alert('Please select a date.');
        return false;
    }
    return true;
}

function setAllStatus(status) {
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        if (radio.value === status) {
            radio.checked = true;
            const customInput = radio.closest('td').querySelector('.status-input');
            if (status === 'Other') {
                customInput.style.display = 'block';
            } else {
                customInput.style.display = 'none';
            }
        }
    });
}

function goBack() {
      // Redirect to index.php
        window.open('index.php', '_self');
        // Close the current tab
        window.close();
}
</script>
</body>
</html>
