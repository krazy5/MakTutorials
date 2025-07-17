<?php include('../database/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card { margin: 20px; }
        .navbar { margin-bottom: 20px; }
        .card-header { font-weight: bold; }
    </style>
</head>
<body>

<!-- Navigation Bar -->

<?php include '../navigation_menu/navigation.php' ?>
<!-- Dashboard Cards -->
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-header">Students</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $result = $conn->query("SELECT COUNT(*) AS count FROM student_record");
                        $row = $result->fetch_assoc();
                        echo $row['count'];
                        ?>
                    </h5>
                    <p class="card-text">Total Registered Students</p>
                    <a href="../student_crud/studentsmanagement.php" class="btn btn-light">Manage Students</a>
                </div>
            </div>
        </div>
		<div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-header">Fees Chart</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $result = $conn->query("SELECT COUNT(*) AS count FROM fees_chart");
                        $row = $result->fetch_assoc();
                        echo $row['count'];
                        ?>
                    </h5>
                    <p class="card-text">Total Data</p>
                    <a href="../fees_chart_crud/fees_chart.php" class="btn btn-light">Watch Fees Chart</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-header">Batches</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $result = $conn->query("SELECT COUNT(*) AS count FROM batch");
                        $row = $result->fetch_assoc();
                        echo $row['count'];
                        ?>
                    </h5>
                    <p class="card-text">Total Batches</p>
                    <a href="batches.php" class="btn btn-light">Manage Batches</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-header">Fees Record</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $result = $conn->query("SELECT SUM(total_fees) AS total FROM fees_record");
                        $row = $result->fetch_assoc();
                        echo "₹" . $row['total'];
                        ?>
                    </h5>
                    <p class="card-text">Total Payments Received</p>
                    <a href="../fees_record_crud/fees_management.php" class="btn btn-light">Manage Fees</a>
                </div>
            </div>
        </div>
		<div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-header">Enquiry</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $result = $conn->query("SELECT count(*) AS total FROM enquiry");
                        $row = $result->fetch_assoc();
                        echo  $row['total'];
                        ?>
                    </h5>
                    <p class="card-text">Total Enquiry</p>
                    <a href="../enquiry_crud/index.php" class="btn btn-light">Manage Enquiry</a>
                </div>
            </div>
        </div>
		<div class="col-md-4">
            <div class="card text-white bg-secondary">
                <div class="card-header">Attendance</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $result = $conn->query("SELECT count(*) AS total FROM attendance_record");
                        $row = $result->fetch_assoc();
                        echo $row['total'];
                        ?>
                    </h5>
                    <p class="card-text">Attendance</p>
                    <a href="../attendance_crud/index.php" class="btn btn-light">Manage Attendance</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark">
                <div class="card-header">Test Performance</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $result = $conn->query("SELECT count(*) AS total FROM student_tests");
                        $row = $result->fetch_assoc();
                        echo $row['total'];
                        ?>
                    </h5>
                    <p class="card-text">Attendance</p>
                    <a href="../test_crud/index.php" class="btn btn-light">Manage Attendance</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add more cards as needed -->
</div>

</body>
</html>
	