
<?php
header("Content-Type: application/json");


$method = $_SERVER['REQUEST_METHOD'];

require "../database/config.php";
//============================code for inserting =========================================
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
        $imagePath = "../student_pic/" .$first_name. basename($image["name"])."jpg";

        if (move_uploaded_file($image["tmp_name"], $imagePath)) {
            $imageUrl="../../".$imagePath;
            $sql = "INSERT INTO student_record (student_id, photo,first_name, last_name,parent_name,mobile_no,gender,roll_no,start_date,std,email,reciept_no,school_college,dob,address,class_subject
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssssssssssssss",$student_id, $imageUrl,$first_name,$last_name,$parent_name,$mobile_no,$gender,$roll_no,$start_date,$std,$email,$reciept_no,$school_college,$dob,$address,$class_subject
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
// ===============================code for fetching ==============================
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $qry="select * from student_record";
        $raw=mysqli_query($conn,$qry);
        
        while($res=mysqli_fetch_array($raw)){
            
            $data[]=$res;
        }
        echo json_encode($data); 
}
//=================================code for updateing ==================================
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    
    // Check if student ID is provided
    // if (!isset($_POST['id']) || empty($_POST['id'])) {
    //     $response['error'] = true;
    //     $response['message'] = "Student ID is required!";
    //     echo json_encode($response);
    //     exit();
    // }

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
        $sql = "UPDATE student_record SET first_name=?, last_name=?, rollno=?, parent_name=?, dob=?, mobile_no=?, gender=?, 
                address=?, batch_name=?, start_date=?, class_subject=?, school_college=?, email=?, std=?, password=?, 
                reciept_no=?, photo=? WHERE student_id=?";
    } else {
        $sql = "UPDATE student_record SET first_name=?, last_name=?, rollno=?, parent_name=?, dob=?, mobile_no=?, gender=?, 
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
$conn->close();
?>