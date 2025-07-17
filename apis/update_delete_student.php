<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);


$method = $_SERVER['REQUEST_METHOD'];

require "../database/config.php";




//=================================code for updateing ==================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    //Check if student ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $response['error'] = true;
        $response['message'] = "Student ID is required!";
        echo json_encode($response);
        exit();
    }

    // Retrieve data from the request
    $student_id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $rollno = $_POST['rollno'];
    $parent_name = $_POST['parent_name'];
    $dob = $_POST['dob'];
    $mobile_no = $_POST['mobile_no'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $batch_name = $_POST['batch_name'];
    $start_date = $_POST['start_date'];
    $class_subject = $_POST['class_subject'];
    $school_college = $_POST['school_college'];
    $email = $_POST['email'];
    $std = $_POST['std'];
    $password = $_POST['password'];
    $receipt_no = $_POST['reciept_no'];

    // Handle Image Upload (If provided)
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../student_pic/";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file; // Save path to store in DB
        } else {
            $response['error'] = true;
            $response['message'] = "Image upload failed!";
            echo json_encode($response);
            exit();
        }
    }

    // Prepare SQL statement
    if ($image_path) {
        $sql = "UPDATE student_record SET first_name=?, last_name=?, roll_no=?, parent_name=?, dob=?, mobile_no=?, gender=?, 
                address=?, batch_name=?, start_date=?, class_subject=?, school_college=?, email=?, std=?, password=?, 
                reciept_no=?, photo=? WHERE student_id=?";
    } else {
        $sql = "UPDATE student_record SET first_name=?, last_name=?, roll_no=?, parent_name=?, dob=?, mobile_no=?, gender=?, 
                address=?, batch_name=?, start_date=?, class_subject=?, school_college=?, email=?, std=?, password=?, 
                reciept_no=? WHERE student_id=?";
    }

    // Prepare and bind parameters
    if ($stmt = $conn->prepare($sql)) {
        if ($image_path) {
            $stmt->bind_param("ssssssssssssssssss", $first_name, $last_name, $rollno, $parent_name, $dob, $mobile_no, $gender,
                $address, $batch_name, $start_date, $class_subject, $school_college, $email, $std, $password, $receipt_no, $image_path, $student_id);
        } else {
            $stmt->bind_param("sssssssssssssssss", $first_name, $last_name, $rollno, $parent_name, $dob, $mobile_no, $gender,
                $address, $batch_name, $start_date, $class_subject, $school_college, $email, $std, $password, $receipt_no, $student_id);
        }

        // Execute statement
        if ($stmt->execute()) {
            $response['error'] = false;
            $response['message'] = "Student updated successfully!";
        } else {
            $response['error'] = true;
            $response['message'] = "Failed to update student!";
        }

        $stmt->close();
    } else {
        $response['error'] = true;
        $response['message'] = "Database error!";
    }

    echo json_encode($response);
    $conn->close();
} 

//===================================Deleting student=========================================================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get student ID from the URL
    $student_id = $_GET['id'] ?? null; // Retrieves ID from URL query parameter

    if (!empty($student_id)) {
        $query = "DELETE FROM student_record WHERE student_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $student_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Student deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete student."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid student ID."]);
    }
}
$conn->close();
?>