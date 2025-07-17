<?php
header("Content-Type: application/json");
require "database/config.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    $imagePath = "student_pic/" . basename($image["name"]);
    
    if (move_uploaded_file($image["tmp_name"], $imagePath)) {
        $sql = "INSERT INTO users (name, email, image_url) VALUES ('$name', '$description', '$imagePath')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "File uploaded successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "File upload failed"]);
    }
}

$conn->close();
?>
