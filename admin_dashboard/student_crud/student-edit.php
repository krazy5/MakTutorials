<?php

require '../database/config.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Student Edit</title>
</head>
<body>
     <!-- Navigation Bar -->
    <?php include '../navigation_menu/navigation.php' ?>
    
     <div class="container mt-5">
        <?php include('message.php'); ?> 
        <div class="row">
            
            <div class="col-md-12 "> 
                <div class="card">
                    <div class="card-header">
                        <h4><strong>Student Edit Details </strong>
                            <a href="javascript:void(0);" class="btn btn-danger float-end" onclick="goBack()">Back</a>
                        </h4>
                    </div>
                </div>
                
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
                                
                <form action="code.php" method="post" enctype="multipart/form-data">
                
                    <div class="row">
                        <div class="col-md-3 ">
                            <label><b>Student_id</b></label>
                            <input type="text" class="form-control" name="student_id" value="<?=$student['student_id'];?>">  
                        </div>
                    
                        <div class="col-md-3 ">
                            <label><b>First Name</b></label>
                            <input type="text" name="first_name" value="<?=$student['first_name'];?>" class="form-control">
                        </div>
						
						<div class="col-md-3 ">
                            <label><b>Last Name</b></label>
                            <input type="text" name="last_name" value="<?=$student['last_name'];?>" class="form-control">
                        </div>
                    
                        <div class="col-md-3 ">
                            <label><b>STD</b></label>
                            <input type="text" name="std" value="<?=$student['std'];?>" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-8">
                            <label><b>Address</b></label>
                            <input type="text" name="address" value="<?=$student['address'];?>" class="form-control">
                        </div>
                    
                        <div class="col-4 ">
                            <label><b>Date of Birth</b></label>
                            <input type="Date" name="dob" value="<?=$student['dob'];?>" class="form-control">
                        </div>
                        
                    </div>    
                    
                    
                    <div class="row">
                    
                        <div class="col-6 ">
                            <label><b>Mobile no.</b></label>
                            <input type="text" name="mobile_no" value="<?=$student['mobile_no'];?>" class="form-control">
                        </div>
                    
                        <div class="col-6 ">
                            <label><b>Gender</b></label>
							<select name="gender" class="form-control" >
								<option value="<?=$student['gender'];?>"><?=$student['gender'];?></option>
								<option value="male">Male</option>
								<option value="female">Female</option>
							
							  </select>
                           
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6 ">
                            <label><b>Start Date</b></label>
                            <input type="Date" name="start_date" value="<?=$student['start_date'];?>" class="form-control">
						</div>
                        <div class="col-6 ">
                            <label><b>School/College</b></label>
                            <input type="text" name="school_college" value="<?=$student['school_college'];?>" class="form-control">
                        </div>
                    </div>
					
                    
                    
                    
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center  mb-3">
                            <button type="button" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#demo">click to add optional fields</button>
                        </div>
                    </div>
                    
				
				<div id="demo" class="collapse">	
                    <div class="row">
                        <div class="col-4 ">
                            <label><b>Subjects</b></label>
                            <input type="text" name="class_subject" value="<?=$student['class_subject'];?>" class="form-control">                    
                        </div>
                        <div class="col-4 ">
                            <label><b>Reciept No</b></label>
                            <input type="text" name="reciept_no" value="<?=$student['reciept_no'];?>" class="form-control">
                        </div>
                        <div class="col-4 ">
							<img src='<?=$student['photo']?>?v=<?=time()?>' width="100px" class="img-rounded">
                            <label><b>change & upload new	 photo</b></label>
                            <input type="file" name="photo"  value="<?=$student['photo'];?>" class="form-control">
                        </div>
                    </div> 
                    
                    
                    
                    <div class="row">
                         <div class="col-4 ">
                            <label><b>rollno</b></label>
                            <input type="number" name="roll_no" value="<?=$student['roll_no'];?>" class="form-control" >
                        </div>
                        <div class="col-4 ">
                            <label><b>Batch</b></label>
                            <input type="text" name="batch_name" class="form-control" value="<?=$student['batch_name'];?>">
                        </div>
                    </div>    
                </div>
                
                <br>
                <div class="col-md-12 "> 
                <div class="card">
                    <div class="card-header">
                        <div class="mb-3">
                            <button type="submit" name="update_student" class="btn btn-primary"><b>Update Student</b></button>
                        </div>
                    </div>
                </div>
                </form>
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
    
    
    <br>
    <hr>
    <br>
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