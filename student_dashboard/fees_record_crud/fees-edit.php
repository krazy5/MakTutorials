<?php
include('../database/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch data from student_record, fees_record, and installments tables
    $query = "SELECT student_record.photo, student_record.first_name, student_record.last_name, student_record.student_id, 
                     fees_record.total_fees, fees_record.received_fees, fees_record.balance_fees, 
                     installments.installment_no, installments.amount, installments.due_date, installments.receive_date, installments.payment_mode, installments.status
              FROM student_record
              INNER JOIN fees_record ON student_record.student_id = fees_record.student_id
              INNER JOIN installments ON fees_record.fr_id = installments.fr_id
              WHERE student_record.student_id='$id'";
    
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fees Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<!-- Navigation Bar -->

<?php include '../Navigation_menu/navigation.php' ?>
						<h4>
                            <a href="fees_management.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
<div class="container">
    <h2>Edit Fees Record</h2>
    <form action="code.php" method="post">
        <!-- Display Photo and Student Info -->
        <div class="form-group">
            <label>Student Photo:</label><br>
            <img src="<?=$row['photo']?>" alt="student photo" width="100px" height="100px" style="object-fit: cover;">
        </div>
        <div class="form-group">
            <label>Student Name:</label>
            <input type="text" class="form-control" value="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Student ID:</label>
            <input type="text" class="form-control" name="student_id" value="<?php echo $row['student_id']; ?>" readonly>
        </div>

        <!-- Fees Record Fields -->
         <div class="form-group">
            <label>Total Fees:</label>
            <input type="number" name="total_fees" id="total_fees" class="form-control" value="<?php echo $row['total_fees']; ?>" oninput="calculateBalance()">
        </div>
        <div class="form-group">
            <label>Received Fees:</label>
            <input type="number" name="received_fees" id="received_fees" class="form-control" value="<?php echo $row['received_fees']; ?>" oninput="calculateBalance()">
        </div>
        <div class="form-group">
            <label>Balance Fees:</label>
            <input type="number" name="balance_fees" id="balance_fees" class="form-control" value="<?php echo $row['balance_fees']; ?>" readonly>
        </div>

        <!-- Installment Record Fields -->
        <div class="form-group">
            <label>Installment No:</label>
            <input type="number" name="installment_no" class="form-control" value="<?php echo $row['installment_no']; ?>" required>
        </div>
        <div class="form-group">
            <label>Amount:</label>
            <input type="number" name="amount" class="form-control" value="<?php echo $row['amount']; ?>" required>
        </div>
        <div class="form-group">
            <label>Due Date:</label>
            <input type="date" name="due_date" class="form-control" value="<?php echo $row['due_date']; ?>" required>
        </div>
        <div class="form-group">
            <label>Receive Date:</label>
            <input type="date" name="receive_date" class="form-control" value="<?php echo $row['receive_date']; ?>">
        </div>
       <div class="form-group">
            <label>Payment Mode:</label>
            <select name="payment_mode" class="form-control">
                <option value="cash" <?php echo ($row['payment_mode'] == 'cash') ? 'selected' : ''; ?>>Cash</option>
                <option value="bank_transfer" <?php echo ($row['payment_mode'] == 'bank_transfer') ? 'selected' : ''; ?>>Bank Transfer</option>
                <option value="upi" <?php echo ($row['payment_mode'] == 'upi') ? 'selected' : ''; ?>>UPI</option>
                <option value="card" <?php echo ($row['payment_mode'] == 'card') ? 'selected' : ''; ?>>Card</option>
            </select>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status" class="form-control">
                <option value="pending" <?php echo ($row['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="paid" <?php echo ($row['status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                <option value="overdue" <?php echo ($row['status'] == 'overdue') ? 'selected' : ''; ?>>Overdue</option>
            </select>
        </div>

        <button type="submit" name="update_fees" class="btn btn-primary">Update</button>
    </form>
</div>
<script>
      function calculateBalance() {
        // Fetch values from the input fields
        const totalFees = parseFloat(document.getElementById('total_fees').value) || 0;
        const receivedFees = parseFloat(document.getElementById('received_fees').value) || 0;
        
        // Calculate the balance fees
        const balanceFees = totalFees - receivedFees;

        // Ensure that the balance fees do not show negative values
        document.getElementById('balance_fees').value = balanceFees >= 0 ? balanceFees : 0;
    }
</script>
</body>
</html>
