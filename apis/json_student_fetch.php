<?php
require "../database/config.php";


$qry="select * from student_record";
$raw=mysqli_query($conn,$qry);

while($res=mysqli_fetch_array($raw)){
    
    $data[]=$res;
}
echo json_encode($data); 
?>