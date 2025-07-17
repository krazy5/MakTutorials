<?php
require "database/config.php";
header('Content-Type: application/json');

$uname=trim($_POST['email']);
$pwd=trim($_POST['password']);
$qry="select * from admin where email='$uname' and password='$pwd'";
$raw=mysqli_query($conn,$qry);
$count=mysqli_num_rows($raw);
if($count>0){
    
    $response['message']="exist";
}
else{
    $response['message']="failed";
}
echo json_encode($response); 
?>