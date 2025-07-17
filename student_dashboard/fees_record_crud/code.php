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
        $_SESSION['message'] = "Student Not Deleted";
        header("Location: studentsmanagement.php");
        exit(0);
    }
}

if(isset($_POST['update_fees'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $total_fees = mysqli_real_escape_string($conn, $_POST['total_fees']);
    $received_fees = mysqli_real_escape_string($conn, $_POST['received_fees']);
    $balance_fees = mysqli_real_escape_string($conn, $_POST['balance_fees']);
    $installment_no = mysqli_real_escape_string($conn, $_POST['installment_no']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $receive_date = mysqli_real_escape_string($conn, $_POST['receive_date']);
    $payment_mode = mysqli_real_escape_string($conn, $_POST['payment_mode']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Update the fees_record table
    $query_fees = "UPDATE fees_record SET total_fees=?, received_fees=?, balance_fees=?, updated_at=current_timestamp() WHERE student_id=?";
    $stmt_fees = $conn->prepare($query_fees);
    $stmt_fees->bind_param("dddi", $total_fees, $received_fees, $balance_fees, $student_id);
    $query_fees_run = $stmt_fees->execute();

    // Get the fr_id for the student's fees record
    $query_get_fr_id = "SELECT fr_id FROM fees_record WHERE student_id=?";
    $stmt_get_fr_id = $conn->prepare($query_get_fr_id);
    $stmt_get_fr_id->bind_param("i", $student_id);
    $stmt_get_fr_id->execute();
    $stmt_get_fr_id->bind_result($fr_id);
    $stmt_get_fr_id->fetch();
    $stmt_get_fr_id->close();

    // Update the installments table
    $query_installment = "UPDATE installments SET installment_no=?, amount=?, due_date=?, receive_date=?, payment_mode=?, status=? WHERE fr_id=?";
    $stmt_installment = $conn->prepare($query_installment);
    $stmt_installment->bind_param("idssssi", $installment_no, $amount, $due_date, $receive_date, $payment_mode, $status, $fr_id);
    $query_installment_run = $stmt_installment->execute();

    // Check for errors
    if ($query_fees_run && $query_installment_run) {
        $_SESSION['message'] = "Fees Record Updated Successfully";
    } else {
        $_SESSION['message'] = "Fees Record Not Updated. Error: " . mysqli_stmt_error($stmt_fees) . " " . mysqli_stmt_error($stmt_installment);
    }

    // Close the statements
    $stmt_fees->close();
    $stmt_installment->close();

    // Redirect back to the edit page
    header("Location: fees_management.php");
    exit(0);
}






if (isset($_POST['save_fees'])) {


		// Get POST data
		$student_id = $_POST['student_id'];
		$total_fees = $_POST['total_fees'];
		$received_fees = $_POST['received_fees'];
		$balance_fees = $_POST['balance_fees'];
		$installment_no = $_POST['installment_no'];
		$amount = $_POST['amount'];
		$due_date = $_POST['due_date'];
		$receive_date = $_POST['receive_date'];
		$payment_mode = $_POST['payment_mode'];
		$status = $_POST['status'];

		// Insert into fees_record table using a prepared statement
		$query_fees = "INSERT INTO fees_record (student_id, total_fees, received_fees, balance_fees, created_at, updated_at) VALUES (?, ?, ?, ?, current_timestamp(), current_timestamp())";
		$stmt_fees = $conn->prepare($query_fees);
		$stmt_fees->bind_param("iddd", $student_id, $total_fees, $received_fees, $balance_fees);
		$stmt_fees->execute();

		// Get the last inserted ID in the fees_record table
		$fr_id = $conn->insert_id;

		// Insert into installments table using a prepared statement
		$query_installment = "INSERT INTO installments (fr_id, installment_no, amount, due_date, receive_date, payment_mode, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$stmt_installment = $conn->prepare($query_installment);
		$stmt_installment->bind_param("iidssss", $fr_id, $installment_no, $amount, $due_date, $receive_date, $payment_mode, $status);
		$stmt_installment->execute();

		// Close the prepared statements
		$stmt_fees->close();
		$stmt_installment->close();

		// Redirect to the fees_management.php page
		header("Location: fees_management.php");
		exit();
		

}


?>