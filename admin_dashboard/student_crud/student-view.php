<?php
require '../database/config.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Student View</title>
    <style>
        .form-container {
            background-color: ##ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .photo-container {
            text-align: right;
        }
        .photo-container img {
            border-radius: 10px;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-control-plaintext {
            font-size: 1rem;
            padding-left: 0;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .photo-container {
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
<?php include '../navigation_menu/navigation.php' ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Student View Details 
                            <a href="javascript:void(0);" class="btn btn-danger float-end" onclick="goBack()">Back</a>
                        </h4>
                    </div>
                    <div class="card-body form-container">
                        <?php
                        if(isset($_GET['id']))
                        {
                            $student_id = mysqli_real_escape_string($conn, $_GET['id']);
                            $query = "SELECT * FROM student_record WHERE student_id='$student_id' ";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $student = mysqli_fetch_array($query_run);
                                ?>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label">Student ID</label>
                                            <p class="form-control-plaintext"> <?=$student['student_id'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Student Name</label>
                                            <p class="form-control-plaintext"> <?=$student['first_name'];?> <?=$student['last_name'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Roll Number</label>
                                            <p class="form-control-plaintext"> <?=$student['roll_no'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Parent Name</label>
                                            <p class="form-control-plaintext"> <?=$student['parent_name'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Date of Birth</label>
                                            <p class="form-control-plaintext"> <?=$student['dob'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mobile Number</label>
                                            <p class="form-control-plaintext"> <?=$student['mobile_no'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Gender</label>
                                            <p class="form-control-plaintext"> <?=$student['gender'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <p class="form-control-plaintext"> <?=$student['address'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Batch Name</label>
                                            <p class="form-control-plaintext"> <?=$student['batch_name'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Start Date</label>
                                            <p class="form-control-plaintext"> <?=$student['start_date'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Class Subject</label>
                                            <p class="form-control-plaintext"> <?=$student['class_subject'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">School/College</label>
                                            <p class="form-control-plaintext"> <?=$student['school_college'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <p class="form-control-plaintext"> <?=$student['email'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Standard</label>
                                            <p class="form-control-plaintext"> <?=$student['std'];?> </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Receipt Number</label>
                                            <p class="form-control-plaintext"> <?=$student['reciept_no'];?> </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 photo-container">
                                        <img src='<?=$student['photo']?>?v=<?=time()?>' alt="Student Photo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-center">
                                        <a href="studentsmanagement.php" class="btn btn-custom">Home</a>
                                    </div>
                                </div>
                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
	function goBack() {
        // Redirect to index.php
        window.open('studentsmanagement.php', '_self');
        // Close the current tab
        window.close();
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
