<?php
session_start();
require "../database/config.php";

//--------------------to delete record below code ------------------------------
if(isset($_POST['delete_fc']))
{
    $fc_id = mysqli_real_escape_string($conn, $_POST['delete_fc']);
	
    $query = "DELETE  FROM fees_chart WHERE fc_id='$fc_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Student Deleted Successfully";
        header("Location: fees_chart.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Student Not Deleted";
        header("Location: fees_chart.php");
        exit(0);
    }
}

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
    
    // Get the old data
    $query = "SELECT * FROM student_record WHERE student_id='$student_id'";
    $result = mysqli_query($conn, $query);
    $old_data = mysqli_fetch_assoc($result);
    
    // Handle photo upload if a new file is provided
    $photo_folder = $old_data['photo']; // Default to the old photo

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_ext = pathinfo($photo, PATHINFO_EXTENSION);
        $photo_name = $first_name . $last_name . '.jpg'; // Naming the file as first_name+last_name.jpg
        $photo_folder = 'student_pic/' . $photo_name;

        if (move_uploaded_file($photo_tmp, $photo_folder)) {
            // Photo uploaded successfully, update the file path
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
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['message'] = "Student Updated Successfully";
        } else {
            $_SESSION['message'] = "No changes were made to the record.".$photo_folder;
        }
    } else {
        $_SESSION['message'] = "Student Not Updated. Error: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    header("Location: student-edit.php?id=$student_id");
    exit(0);
}




//-------------------------------------- saving or inserting code below ----------------------------------------

if (isset($_POST['save_fc'])) {
    // Assuming $conn is your database connection

    $board_exam = isset($_POST['board_exam']) ? $_POST['board_exam'] : '';
    $std = isset($_POST['std']) ? $_POST['std'] : '';
    $yearly_fees = isset($_POST['yearly_fees']) ? $_POST['yearly_fees'] : 0;
    $monthly_fees = isset($_POST['monthly_fees']) ? $_POST['monthly_fees'] : 0;
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
    

    
          
                // Use prepared statement to prevent SQL injection
                $query = "INSERT INTO fees_chart(board_exam, std, yearly_fees, monthly_fees, subject, remarks) 
                          VALUES (?, ?, ?, ?, ?,?)";

                // Prepare the statement and check for errors
                $stmt = mysqli_prepare($conn, $query);

                if (!$stmt) {
                    die('Error in preparing statement: ' . mysqli_error($conn));
                }

                // Bind parameters to the prepared statement
                mysqli_stmt_bind_param($stmt, "ssddss", $board_exam,$std, $yearly_fees, $monthly_fees, $subject, $remarks);

                // Execute the prepared statement
                $query_run = mysqli_stmt_execute($stmt);

                if ($query_run) {
                    $_SESSION['message'] = "cahrt Created Successfully";
                } else {
                    $_SESSION['message'] = "chart Not Created";
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            
    

    header("Location: fc_create.php");
    exit(0);
}


?>