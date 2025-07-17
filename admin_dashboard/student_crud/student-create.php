<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Student Create</title>
</head>
<body>
    
 
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><strong>Student Add</strong> 
                            <a href="javascript:void(0);" class="btn btn-danger float-end" onclick="goBack()">Back</a>
                        </h4>
                    </div>
                 </div>
            </div>
        
        
                    

                        <form action="code.php" method="post" enctype="multipart/form-data">
                
                    <div class="row">
                        						
						<div class="col-6">
                            <label><b>First Name</b></label>
                            <input type="text" name="first_name" class="form-control">
                        </div>
						
						<div class="col-6">
                            <label><b>Last Name</b></label>
                            <input type="text" name="last_name" class="form-control">
                        </div>
                                                               
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-8">
                            <label><b>Address</b></label>
                            <input type="text" name="address" class="form-control">
                        </div>
                    
                        <div class="col-4 ">
                            <label><b>Date of Birth</b></label>
                            <input type="Date" name="dob" class="form-control">
                        </div>
                        
                    </div>    
                    
                    
                    <div class="row">
                    
                        <div class="col-6 ">
                            <label><b>Mobile no.</b></label>
                            <input type="text" name="mobile_no" class="form-control">
                        </div>
                    
                        <div class="col-6 ">
                            <label><b>Gender</b></label>
							<select name="gender" class="form-control">
								<option value="male">Male</option>
								<option value="female">Female</option>
							
							  </select>
                           
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6 ">
                            <label><b>Standard</b></label>
                            <select name="std" class="form-control ">
								<option value="8th">8th</option>
								<option value="9th">9th</option>
								<option value="10th">10th</option>
								<option value="11th">11th</option>
								<option value="12th">12th</option>
								<option value="BSCIT">BSCIT</option>
								<option value="BSCCS">BSCCS</option>
								<option value="BSCDS">BSCDS</option>
								<option value="BE ENG">BE ENG</option>
							  </select>
						</div>
                        <div class="col-6 ">
                            <label><b>School/College</b></label>
                            <input type="text" name="school_college" class="form-control">
                        </div>
                    </div>
					
                    <div class="row justify-content-center ">
                        <div class="col-4 ">
                            <label><b>Start Date</b></label>
                            <input type="Date" name="start_date" class="form-control">
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
                            <input type="text" name="class_subject" class="form-control">                    
                        </div>
                        <div class="col-4 ">
                            <label><b>Reciept No</b></label>
                            <input type="text" name="reciept_no" class="form-control">
                        </div>
                        <div class="col-4 ">
                            <label><b>upload photo</b></label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div> 
                    
                    
                    
                    <div class="row">
                         <div class="col-4 ">
                            <label><b>rollno</b></label>
                            <input type="number" name="roll_no" class="form-control" >
                        </div>
                        <div class="col-4 ">
                            <label><b>Batch</b></label>
                            <input type="text" name="batch_name" class="form-control">
                        </div>
                    </div>    
                </div>
                
                <br>
                
                <div class="col-12 "> 
                <div class="card">
                    <div class="card-header">
                        <div class="sb-3">
                            <button type="submit" name="save_student" class="btn btn-primary"><b>Save Student</b></button>
                        </div>
                    </div>
                </div>
            </div>     
                </form>
                   
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