<?php
session_start();
require '../database/config.php';

// Fetch the test record based on test_id
$test_id = isset($_GET['test_id']) ? intval($_GET['test_id']) : 0;
$test_query = "SELECT st.*, sr.first_name, sr.last_name, sr.std
               FROM student_tests st
               JOIN student_record sr ON st.student_id = sr.student_id
               WHERE st.test_id = $test_id";
$test_result = mysqli_query($conn, $test_query);
$test_record = mysqli_fetch_assoc($test_result);

// Redirect if no record found
if (!$test_record) {
    $_SESSION['message'] = "Test record not found.";
    header("Location: index.php");
    exit(0);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Mono:wght@400&display=swap" rel="stylesheet">
    <title>View Test Record</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .container {
            font-family: 'Mono', monospace;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .radial-progress {
            position: relative;
            width: 100px;
            height: 100px;
        }
        .radial-progress canvas {
            width: 100% !important;
            height: 100% !important;
        }
        /* Center the percentage inside the chart */
        .radial-progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
 <?php include('message.php'); ?>
    <div class="container mt-4">
       
        <div class="card">
            <div class="card-header">
                <h4>Test Record Details
                    <a href="javascript:void(0)" class="btn btn-danger float-end" onclick="goBack()">Back</a>
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Student Information</h5>
                        <p><strong>Name:</strong> <?= htmlspecialchars($test_record['first_name'] . ' ' . $test_record['last_name']); ?></p>
                        <p><strong>Class/Std:</strong> <?= htmlspecialchars($test_record['std']); ?></p>
                        <p><strong>Subject:</strong> <?= htmlspecialchars($test_record['subject']); ?></p>
                        <p><strong>Marks Obtained:</strong> <?= htmlspecialchars($test_record['marks_obtained']); ?></p>
                        <p><strong>Total Marks:</strong> <?= htmlspecialchars($test_record['total_marks']); ?></p>
                        <p><strong>Percentage:</strong> <?= htmlspecialchars($test_record['percentage']); ?>%</p>
                        <p><strong>Test Date:</strong> <?= htmlspecialchars($test_record['test_date']); ?></p>
                        <p><strong>Grade:</strong> <?= htmlspecialchars($test_record['grade']); ?></p>
                        <p><strong>Remarks:</strong> <?= htmlspecialchars($test_record['remarks']); ?></p>
                        <p><strong>Passed:</strong> <?= $test_record['is_passed'] ? 'Yes' : 'No'; ?></p>
                        <?php if ($test_record['test_file']): ?>
                            <p><strong>Attachment:</strong> <a href="<?= htmlspecialchars($test_record['test_file']); ?>" target="_blank">View File</a></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="radial-progress">
                            <canvas id="percentageChart"></canvas>
                            <div class="radial-progress-text" id="percentageText"></div> <!-- For percentage text -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
          function goBack() {
        // Redirect to index.php
        window.open('index.php', '_self');
        // Close the current tab
        window.close();
    }

        // Setup and render the radial progress chart
        const ctx = document.getElementById('percentageChart').getContext('2d');
        const percentage = <?= json_encode($test_record['percentage']); ?>;
        const percentageText = document.getElementById('percentageText');
        percentageText.innerText = percentage + '%';  // Set the percentage inside the doughnut

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [percentage, 100 - percentage],
                    backgroundColor: ['#007bff', '#e9ecef'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '80%',
                plugins: {
                    tooltip: {
                        enabled: false
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>
