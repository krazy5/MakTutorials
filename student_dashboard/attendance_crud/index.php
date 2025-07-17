<?php
session_start();
include "../database/config.php";

// Check if student is logged in
if (!isset($_SESSION['student'])) {
    echo "Student not logged in.";
    exit();
}

$mobile = $_SESSION['student'];

// Fetch student data
$sql = "SELECT * FROM student_record WHERE mobile_no = '$mobile'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
    $student_id = $student['student_id'];
} else {
    echo "No student found with this mobile number.";
    exit();
}

// Fetch attendance data
$attendance_sql = "SELECT * FROM attendance_record WHERE student_id = '$student_id'";
$attendance_result = mysqli_query($conn, $attendance_sql);

$attendance = [];
$months_with_records = [];
while ($row = mysqli_fetch_assoc($attendance_result)) {
    $attendance[$row['date']] = $row['status'];
    $date_parts = explode('-', $row['date']);
    $year = $date_parts[0];
    $month = $date_parts[1];
    $months_with_records["$year-$month"] = true;
}

// Handle month and year selection
$selected_year = date('Y');
$selected_month = date('m');
if (isset($_GET['year']) && isset($_GET['month'])) {
    $selected_year = $_GET['year'];
    $selected_month = str_pad($_GET['month'], 2, '0', STR_PAD_LEFT);
}

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);

// Initialize summary counters
$total_present = 0;
$total_absent = 0;
$total_holiday = 0;
$total_late = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
/* Calendar Table */
.calendar-table {
    width: 100%;
    border-collapse: separate; /* Important: Allows border-spacing to take effect */
    border-spacing: 8px; /* Adds smaller padding between cells */
}

/* Calendar Table Cells */
.calendar-table td {
    width: 12%; /* Slightly smaller width */
    height: 80px; /* Slightly smaller height */
    text-align: center;
    vertical-align: middle;
    background-color: #f8f9fa;
    border-radius: 10px; /* Rounded corners */
    border: 2px solid white; /* Initial white border for the rounded corners */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Initial shadow */
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s; /* Smooth transition */
}

/* Status-based cells */
.calendar-table td.absent {
    background-color: #f5c6cb;
    color: white;
}

.calendar-table td.present {
    background-color: #c3e6cb;
    color: white;
}

.calendar-table td.holiday {
    background-color: #ffeeba;
    color: black;
}

.calendar-table td.late {
    background-color: #b8daff;
    color: white;
}

.calendar-table td.other {
    background-color: #e2e3e5;
    color: black;
}

/* Glow and 3D effect on hover with black rounded border */
.calendar-table td:hover {
    transform: scale(1.05); /* 3D pop-out effect */
    box-shadow: 0 0 10px 5px rgba(255, 255, 255, 0.6); /* Glowing effect */
    border-color: black; /* Change border color to black on hover for rounded corners */
}

/* Container and dropdowns */
.calendar-container {
    margin-top: 30px;
    padding: 15px;
    border-radius: 10px;
    background-color: #ffffff;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.dropdowns {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

/* 3D Arrow Hover Effect */
.arrow-button {
    font-size: 24px;
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 50%;
    border: none;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    cursor: pointer;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.arrow-button:hover {
    transform: translateY(-5px); /* 3D pop-out on hover */
    box-shadow: 0 8px 16px rgba(0, 123, 255, 0.6); /* Shadow for depth */
}

/* Summary Card */
.summary-card {
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.summary-item {
    margin: 10px;
}

.summary-item p {
    margin: 0;
    font-size: 18px;
}

.summary-item strong {
    font-size: 24px;
}

.summary-container {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .calendar-table td {
        width: 4%; /* Adjust cell width for smaller screens */
        height: 50px; /* Adjust cell height for smaller screens */
    }

    .calendar-container {
        padding: 10px; /* Reduce padding on smaller screens */
    }

    .dropdowns {
        flex-direction: column; /* Stack dropdowns vertically */
        align-items: center;
    }

    .arrow-button {
        font-size: 18px; /* Reduce arrow button size for smaller screens */
        padding: 8px;
    }

    .summary-container {
        flex-direction: column; /* Stack summary items vertically */
        align-items: center;
    }

    .summary-item strong {
        font-size: 20px; /* Adjust summary text size */
    }
}

    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Student Dashboard</h2>

    <div class="card mb-3">
        <div class="card-header">Student Information</div>
        <div class="card-body">
            <p><strong>Name:</strong> <?php echo $student['first_name'] . " " . $student['last_name']; ?></p>
            <p><strong>Roll No:</strong> <?php echo $student['roll_no']; ?></p>
            <p><strong>Mobile No:</strong> <?php echo $student['mobile_no']; ?></p>
            <p><strong>School/College:</strong> <?php echo $student['school_college']; ?></p>
            <p><strong>Batch:</strong> <?php echo $student['batch_name']; ?></p>
        </div>
    </div>

    <div class="calendar-container">
        <h3 class="text-center">Attendance Calendar</h3>

        <div class="dropdowns">
            <form method="GET" class="d-flex">
                <div class="form-group">
                    <label for="month">Month:</label>
                    <select name="month" id="month" class="form-select">
                        <?php
                        for ($m = 1; $m <= 12; $m++) {
                            $month_str = str_pad($m, 2, '0', STR_PAD_LEFT);
                            $selected = ($selected_month == $month_str) ? 'selected' : '';
                            echo "<option value='$m' $selected>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mx-2">
                    <label for="year">Year:</label>
                    <select name="year" id="year" class="form-select">
                        <?php
                        for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++) {
                            $selected = ($selected_year == $y) ? 'selected' : '';
                            echo "<option value='$y' $selected>$y</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Show</button>
                </div>
            </form>
        </div>

        <table class="table table-bordered calendar-table">
            <thead>
                <tr class="table-secondary">
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Determine first day of the month
            $firstDay = date('w', strtotime("$selected_year-$selected_month-01"));
            $day = 1;

            // Start the row for the first week
            echo "<tr>";

            // Print empty cells for days before the first day of the month
            for ($i = 0; $i < $firstDay; $i++) {
                echo "<td></td>";
            }

            // Print the days of the month
            while ($day <= $daysInMonth) {
                // If the week is complete, start a new row
                if (($i % 7) == 0) {
                    echo "</tr><tr>";
                }

                // Get attendance status for the current day
                $currentDate = "$selected_year-$selected_month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                $statusClass = "other";  // Default class
                if (isset($attendance[$currentDate])) {
                    switch ($attendance[$currentDate]) {
                        case 'Absent':
                            $statusClass = "absent";
                            $total_absent++;
                            break;
                        case 'Present':
                            $statusClass = "present";
                            $total_present++;
                            break;
                        case 'Holiday':
                            $statusClass = "holiday";
                            $total_holiday++;
                            break;
                        case 'Late':
                            $statusClass = "late";
                            $total_late++;
                            break;
                    }
                }

                echo "<td class='$statusClass'>$day</td>";
                $day++;
                $i++;
            }

            // Print empty cells after the last day of the month
            while (($i % 7) != 0) {
                echo "<td></td>";
                $i++;
            }

            echo "</tr>";
            ?>
            </tbody>
        </table>

        <div class="summary-container">
            <div class="summary-item">
                <p>Total <strong>Present</strong></p>
                <strong><?php echo $total_present; ?></strong>
            </div>
            <div class="summary-item">
                <p>Total <strong>Absent</strong></p>
                <strong><?php echo $total_absent; ?></strong>
            </div>
            <div class="summary-item">
                <p>Total <strong>Holiday</strong></p>
                <strong><?php echo $total_holiday; ?></strong>
            </div>
            <div class="summary-item">
                <p>Total <strong>Late</strong></p>
                <strong><?php echo $total_late; ?></strong>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
