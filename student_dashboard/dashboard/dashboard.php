<?php include('../database/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
                                    <p class="card-text">Total Registered Students</p>
                    <a href="../student_crud/studentsmanagement.php" class="btn btn-light">Manage Students</a>
                </div>
            </div>
        </div>
		
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-header">Batches</div>
                <div class="card-body">
                  
                    <p class="card-text">Total Batches</p>
                    <a href="batches.php" class="btn btn-light">Manage Batches</a>
                </div>
            </div>
        </div>
        
		
		<div class="col-md-4">
            <div class="card text-white bg-secondary">
                <div class="card-header">Attendance</div>
                <div class="card-body">
                   
                    <p class="card-text">Attendance</p>
                    <a href="../attendance_crud/index.php" class="btn btn-light">Manage Attendance</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark">
                <div class="card-header">Test Record</div>
                <div class="card-body">
                    
                    <p class="card-text">Total Records: <?php
                        $result = $conn->query("SELECT count(*) AS total FROM student_tests");
                        $row = $result->fetch_assoc();
                        echo $row['total'];
                        ?></p>
                    <a href="../test_crud/index.php" class="btn btn-light">Manage Attendance</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add more cards as needed -->
</div>

</body>
</html>
	