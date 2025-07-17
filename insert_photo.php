<?php
  require('database/config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_POST['image'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $imagePath = "student_pic/" . $name . ".jpg";
    file_put_contents($imagePath, base64_decode($image));

  

    $stmt = $conn->prepare("INSERT INTO users (name, email, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $description, $imagePath);

    if ($stmt->execute()) {
        echo "Upload successful";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>