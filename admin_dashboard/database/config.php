<?php
$servername = "127.0.0.1:3306";
$username = "u142468412_dbroot";
$password = "mohsinM1@";
$dbname = "u142468412_mak_tutorialdb";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
