<?php
session_start();
require "../database/config.php";


if(isset($_POST['delete_student']))
{
    $student_id = mysqli_real_escape_string($conn, $_POST['delete_student']);
	
    $query = "DELETE  FROM student_record WHERE student_id='$student_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Student Deleted Successfully";
        header("Location: studentsmanagement.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Student Not Deleted".$query_run." ".$student_id;
        header("Location: studentsmanagement.php");
        exit(0);
    }
}




//Update code --------------------------------------------------


if (isset($_POST['update_student'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $std = mysqli_real_escape_string($conn, $_POST['std']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $mobile_no = mysqli_real_escape_string($conn, $_POST['mobile_no']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $school_college = mysqli_real_escape_string($conn, $_POST['school_college']);
    $roll_no = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $batch_name = mysqli_real_escape_string($conn, $_POST['batch_name']);
    $class_subject = mysqli_real_escape_string($conn, $_POST['class_subject']);
    $reciept_no = mysqli_real_escape_string($conn, $_POST['reciept_no']);
    $photoupdate=false;
    // Get the old data
    $query = "SELECT * FROM student_record WHERE student_id='$student_id'";
    $result = mysqli_query($conn, $query);
    $old_data = mysqli_fetch_assoc($result);
    
    // Move the old image to the old_student_pic folder before updating the new one
    $old_photo_path = $old_data['photo'];
    if (file_exists($old_photo_path)) {
        $old_image_name = basename($old_photo_path);
        // Move the old image to ../../old_student_pic/
        if (!file_exists("../../old_student_pic/" . $old_image_name)) {
            rename($old_photo_path, '../../old_student_pic/' . $old_image_name);
        }
    }
    
    // Handle photo upload if a new file is provided
    $photo_folder = $old_data['photo']; // Default to the old photo

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_ext = pathinfo($photo, PATHINFO_EXTENSION);
        $photo_name = $first_name . $last_name . '.jpg'; // Naming the file as first_name+last_name.jpg
        $photo_folder = '../../student_pic/' . $photo_name;

        // Check if a file with the same name already exists in ../student_pic/ and delete it
        if (file_exists($photo_folder)) {
            unlink($photo_folder); // Delete the old image in ../student_pic/
        }

        // Move the new file to the ../../student_pic/ folder
        if (move_uploaded_file($photo_tmp, $photo_folder)) {
            // New photo uploaded successfully, update the file path
			$photoupdate=true;
        } else {
            $_SESSION['message'] = "Failed to upload the new image.";
            header("Location: student-edit.php?id=$student_id");
            exit(0);
        }
    }

    // Update the student record with the new details
    $query = "UPDATE student_record SET 
                first_name=?, 
                last_name=?, 
                std=?, 
                dob=?, 
                mobile_no=?, 
                gender=?, 
                address=?, 
                start_date=?, 
                school_college=?, 
                roll_no=?, 
                batch_name=?, 
                class_subject=?, 
                reciept_no=?, 
                photo=? 
              WHERE student_id=?";
              
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ssssssssssssssi", $first_name, $last_name, $std, $dob, $mobile_no, $gender, $address, $start_date, $school_college, $roll_no, $batch_name, $class_subject, $reciept_no, $photo_folder, $student_id);

    // Execute the prepared statement
    $query_run = mysqli_stmt_execute($stmt);

    // Check for errors
    if ($query_run) {
        if (mysqli_stmt_affected_rows($stmt) > 0 || $photoupdate) {
            $_SESSION['message'] = "Student Updated Successfully";
        } else {
            $_SESSION['message'] = "No changes were made to the record.";
        }
    } else {
        $_SESSION['message'] = "Student Not Updated. Error: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    header("Location: studentsmanagement.php?id=$student_id");
    exit(0);
}





//Update Ends here -----------------------------------------------



if (isset($_POST['save_student'])) {
    // Assuming $conn is your database connection

    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $parent_name = isset($_POST['parent_name']) ? $_POST['parent_name'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : 0;
    $mobile_no = isset($_POST['mobile_no']) ? $_POST['mobile_no'] : 0;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : 0;
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $school_college = isset($_POST['school_college']) ? $_POST['school_college'] : '';
    $std = isset($_POST['std']) ? $_POST['std'] : '';
    $roll_no = isset($_POST['roll_no']) ? $_POST['roll_no'] : '';
    $batch_name = isset($_POST['batch_name']) ? $_POST['batch_name'] : '';
    $class_subject = isset($_POST['class_subject']) ? $_POST['class_subject'] : '';
    $recipet_no = isset($_POST['recipet_no']) ? $_POST['recipet_no'] : '';

    // Handle file upload
    if (isset($_FILES['photo'])) {
        echo "File upload detected.<br>";
        echo "Temporary file: " . $_FILES['photo']['tmp_name'] . "<br>";
        echo "File name: " . $_FILES['photo']['name'] . "<br>";
        echo "File type: " . $_FILES['photo']['type'] . "<br>";
        echo "File size: " . $_FILES['photo']['size'] . "<br>";

        $photo = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_ext = pathinfo($photo, PATHINFO_EXTENSION);
        $photo_name = $first_name . $last_name . '.jpg'; // Naming the file as first_name+last_name.jpg
        $photo_folder = '../../student_pic/' . $photo_name;

        if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($photo_tmp, $photo_folder)) {
                // Use prepared statement to prevent SQL injection
                $query = "INSERT INTO student_record (first_name, last_name, parent_name, dob, mobile_no, gender, address, start_date, school_college, std, photo, roll_no, batch_name, class_subject, reciept_no) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare the statement and check for errors
                $stmt = mysqli_prepare($conn, $query);

                if (!$stmt) {
                    die('Error in preparing statement: ' . mysqli_error($conn));
                }

                // Bind parameters to the prepared statement
                mysqli_stmt_bind_param($stmt, "sssssssssssdsss", $first_name, $last_name, $parent_name, $dob, $mobile_no, $gender, $address, $start_date, $school_college, $std, $photo_folder, $roll_no, $batch_name, $class_subject, $recipet_no);

                // Execute the prepared statement
                $query_run = mysqli_stmt_execute($stmt);

                if ($query_run) {
                    $_SESSION['message'] = "Student Created Successfully";
                } else {
                    $_SESSION['message'] = "Student Not Created";
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "File upload failed.<br>";
                $_SESSION['message'] = "Failed to upload the image.";
            }
        } else {
            echo "Upload error: " . $_FILES['photo']['error'] . "<br>";
            $_SESSION['message'] = "Failed to upload the image.";
        }
    } else {
        echo "No file detected.<br>";
    }

    header("Location: student-create.php");
    exit(0);
}


?>