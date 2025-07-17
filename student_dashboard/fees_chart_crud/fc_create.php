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
                        <h4><strong>Fees Chart Add</strong> 
                            <a href="javascript:void(0);" class="btn btn-danger float-end" onclick="goBack()">Back</a>
                            
                        </h4>
                    </div>
                 </div>
            </div>
        
        
                    

                        <form action="code.php" method="post" enctype="multipart/form-data">
                
                    <div class="row">
                        						
						<div class="col-6">
                            <label><b>board/exam</b></label>
                            <select name="board_exam" class="form-control">
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
						
						<div class="col-6">
                            <label><b>Std</b></label>
                            <input type="text" name="std" class="form-control">
                        </div>
                                                               
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-6">
                            <label><b>Yearly Fees</b></label>
                            <input type="number" name="yearly_fees" class="form-control">
                        </div>
						<div class="col-6">
                            <label><b>monthy Fees</b></label>
                            <input type="number" name="monthly_fees" class="form-control">
                        </div>
                        
                        
                    </div>    
                    
                    
                    <div class="row">
                    
                        <div class="col-4 ">
                            <label><b>subject</b></label>
                            <input type="text" name="subject" class="form-control">
                        </div>
                    
                        <div class="col-8 ">
                            <label><b>remarks</b></label>
							<textarea  name="remarks" class="form-control"></textarea>
                           
                        </div>
                    </div>
                    
                    
                
                <br>
                
                <div class="col-12 "> 
                <div class="card">
                    <div class="card-header">
                        <div class="sb-3">
                            <button type="submit" name="save_fc" class="btn btn-primary"><b>Save fees chart</b></button>
                        </div>
                    </div>
                </div>
            </div>     
                </form>
                   
        </div>       
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