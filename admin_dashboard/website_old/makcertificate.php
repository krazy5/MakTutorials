<?php
include 'college/database.php';
$searchErr = '';
$employee_details='';
if(isset($_POST['save']))
{
    
	if(!empty($_POST['search']))
	{
		$search = $_POST['search'];
		$sql = "select * from makcertificate where cid like '%$search%' or student_name like '%$search%'";
        $result = mysqli_query($conn, $sql);
        //$employee_details = mysqli_fetch_array($result, MYSQLI_ASSOC);
		//$stmt = $con->prepare("select * from makcertificate where cid like '%$search%' or student_name like '%$search%'");
		//$stmt->execute();
		//$employee_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//print_r("testing kar raha hu");
		
	}
	else
	{echo "inside save";
		$searchErr = "Please enter the information";
	}
   
}

?>
<html>
<head>
<title>Certificate Verification</title>
<link rel="stylesheet" href="bootstrap.css" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap-theme.css" crossorigin="anonymous">
<style>
.container{
	width:70%;
	height:30%;
	padding:20px;
}
</style>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>
	<div class="container">
	<h3><u>Enter Certificate ID or Student Name</u></h3>
	<br/><br/>
	<form class="form-horizontal" action="#" method="post">
	<div class="row">
		<div class="form-group">
		    <label class="control-label col-sm-4" for="email"><b>Search Certificate Information:</b>:</label>
		    <div class="col-sm-4">
		      <input type="text" class="form-control" name="search"  placeholder="search here">
		    </div>
		    <div class="col-sm-2">
		      <button type="submit" name="save" class="btn btn-success btn-sm">Submit</button>
		    </div>
		</div>
		<div class="form-group">
			<span class="error" style="color:red;">* <?php echo $searchErr;?></span>
		</div>
		
	</div>
    </form>
	<br/><br/>
	
	    
	    		<?php
	    	    
	    		
	    		if (mysqli_num_rows($result) > 0) {
	    		    ?>
	    		    <h3><u>Search Result</u></h3><br/>
	<div class="table-responsive">          
	  <table class="table" border="2dp">
	    		    <thead>
	      <tr>
	        <th>#</th>
	        <th>certificate ID</th>
	        <th>Student Name</th>
	        <th>Course</th>
	        <th>valid From</th>
	        <th>valid Upto</th>
	      </tr>
	    </thead>
	    <tbody>
	    		    
	    		    <?php
  // output data of each row
  while($value = mysqli_fetch_assoc($result)) {
 
        ?>
                <tr>
		    	 		<td><?php echo $key+1;?></td>
		    	 		<td><?php echo $value['cid']; ?></td>
		    	 		<td><?php echo $value['student_name'];?></td>
		    	 		<td><?php echo $value['course'];?></td>
		    	 		<td><?php echo $value['valid_from'];?></td>
		    	 		<td><?php echo $value['valid_upto'];?></td>
		    	 		
		    	 	</tr>
		    	 	<?php
  }
} else {
  echo "0 results";
}
	    		
		    	
		    	 
		    	?>
	    	
	     </tbody>
	  </table>
	</div>
</div>
<script src="jquery-3.2.1.min.js"></script>
<script src="bootstrap.min.js"></script>
</body>
</html>