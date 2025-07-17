<?php
require('database/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $student_id = $_POST['id'];
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $password = $_POST['password'];
    $parent_name = $_POST['parentName'];
    $mobile_no = $_POST['mobileNo'];
    $std = $_POST['std'];
    $batch_name = $_POST['batchName'];
    $class_subject = $_POST['classSubject'];
    $school_college = $_POST['schoolCollege'];
    $reciept_no = $_POST['receiptNo'];
    $roll_no = $_POST['rollNo'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $start_date = $_POST['startDate'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $image = $_POST['image'];

    // Save the image to the server
    $imagePath = "../../student_pic/" . $student_id . ".jpg";
    if (!file_put_contents($imagePath, base64_decode($image))) {
        echo "Failed to save image.";
        exit;
    }

    // Insert data into the database
    $stmt = $conn->prepare(
        "INSERT INTO student_record (
            photo, student_id, first_name, last_name, roll_no, parent_name, dob, mobile_no,
            gender, address, batch_name, start_date, class_subject, school_college, email,
            std, reciept_no, password
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sissssssssssssssis",
        $imagePath, $student_id, $first_name, $last_name, $roll_no, $parent_name, $dob, $mobile_no,
        $gender, $address, $batch_name, $start_date, $class_subject, $school_college, $email,
        $std, $reciept_no, $password
    );

    if ($stmt->execute()) {
        echo "Upload successful";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
