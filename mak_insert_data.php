
<?php
header("Content-Type: application/json");




require "database/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'] ?? "";//
    $first_name = $_POST['first_name'] ?? "";//
    $last_name = $_POST['last_name'] ?? "";//
    $rollno = $_POST['rollno'] ?? "";//
    $parent_name = $_POST['parent_name'] ?? "";//
    $dob = $_POST['dob'] ?? "";//
    $mobile_no = $_POST['mobile_no'] ?? "";//
    $gender = $_POST['gender'] ?? "";//
    $address = $_POST['address'] ?? "";//
    $batch_name = $_POST['batch_name'] ?? "";
    $start_date = $_POST['start_date'] ?? "";//
    $class_subject = $_POST['class_subject'] ?? "";
    $school_college = $_POST['school_college'] ?? "";//
    $email = $_POST['email'] ?? "";//
    $std = $_POST['std'] ?? "";//
    $password = $_POST['password'] ?? "";//
    $reciept_no = $_POST['reciept_no'] ?? "";//

    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];//
        $imagePath = "student_pic/" . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $imagePath)) {
            $sql = "INSERT INTO student_record (student_id, photo,first_name, last_name,parent_name,mobile_no,gender,roll_no,start_date,std,email,reciept_no,school_college,dob,address,class_subject
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssssssssssssss",$student_id, $imagePath,$first_name,$last_name,$parent_name,$mobile_no,$gender,$roll_no,$start_date,$std,$email,$reciept_no,$school_college,$dob,$address,$class_subject
            );

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "File uploaded successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "File upload failed"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No file uploaded"]);
    }
}

$conn->close();
?>