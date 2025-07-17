<?php
session_start();
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
    
    
     <div class="container mt-5">
        <?php include('message.php'); ?> 
        <div class="row">
            
            <div class="col-md-12 "> 
                <div class="card">
                    <div class="card-header">
                        <h4><strong>Edit Details Fees Chart</strong>
                            <a href="javascript:void(0);" class="btn btn-danger float-end" onclick="goBack()">Back</a>
                        </h4>
                    </div>
                </div>
                
                <?php
                        if(isset($_GET['id']))
                        {
                            $fc_id = mysqli_real_escape_string($conn, $_GET['id']);
                            $query = "SELECT * FROM fees_chart WHERE fc_id='$fc_id' ";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $student = mysqli_fetch_array($query_run);
                                ?>
                                
                <form action="code.php" method="post" enctype="multipart/form-data">
                
                    <div class="row">
                        <div class="col-md-3 ">
                            <label><b>Fc_id</b></label>
                            <input type="text" class="form-control" name="fc_id" value="<?=$student['fc_id'];?>">  
                        </div>
                    
                        <div class="col-md-6 ">
                            
						
                            <label><b>board/exam</b></label>
                            <select name="board_exam" class="form-control">
								<option value="<?=$student['board_exam'];?>"><?=$student['board_exam'];?></option>
								<option value="maharashtra board">maharashtra board</option>
								<option value="cbse board">cbse board</option>
								<option value="icse board">icse board</option>
								<option value="JEE">JEE</option>
								<option value="NEET">NEET</option>
								<option value="other entrance exam">Other entrance exam</option>
								<option value="Bsc IT">Bsc IT</option>
								<option value="Bsc Cs">Bsc cs</option>
								<option value="Bsc Ds">Bsc Data science</option>
								<option value="BE Eng">Engineering</option>
							  </select>
                        
                            
                        </div>
												                    
                        <div class="col-md-3 ">
                            <label><b>STD</b></label>
                            <input type="text" name="std" value="<?=$student['std'];?>" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-3">
                            <label><b>yearly_fees</b></label>
                            <input type="number" name="yearly_fees" value="<?=$student['yearly_fees'];?>" class="form-control">
                        </div>
                    
                        <div class="col-3 ">
                            <label><b>monthly_fees</b></label>
                            <input type="number" name="monthly_fees" value="<?=$student['monthly_fees'];?>" class="form-control">
                        </div>
                        
						<div class="col-6 ">
                            <label><b>Remark</b></label>
                            <input type="number" name="remarks" value="<?=$student['remarks'];?>" class="form-control">
                        </div>
                        
                    </div>    
                    
                    
                    
                    </div>
                    
                    
                    </div>
					
                   
                
                <br>
                <div class="col-md-12 "> 
                <div class="card">
                    <div class="card-header">
                        <div class="mb-3">
                            <button type="submit" name="update_fc" class="btn btn-primary"><b>Update Fees Chart</b></button>
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
        window.open('fees_chart.php', '_self');
        // Close the current tab
        window.close();
    }
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>