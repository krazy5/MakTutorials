<!doctype html>
<html lang="en">
<head>
    <title>Add Fees</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        .form-container { margin: 50px auto; max-width: 600px; }
        .student-info { margin-top: 20px; }
        .student-photo { max-width: 100px; max-height: 100px; object-fit: cover; }
    </style>
</head>
<body class="bg-light">
<!-- Navigation Bar -->

<?php include '../Navigation_menu/navigation.php' ?>

    <div class="container form-container">
        <h2 class="text-center">Add Fees</h2><h4>
                            <a href="fees_management.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
        <form action="code.php" method="POST">
            <div class="form-group mb-3">
                <label for="student_id" class="form-label">Select Student</label>
                <select class="form-select" id="student_id" name="student_id" required onchange="fetchStudentInfo(this.value)">
                    <option value="" disabled selected>Select Student</option>
						<?php
						include "../database/config.php";
						$query = "SELECT student_id, first_name, last_name 
								  FROM student_record 
								  WHERE student_id NOT IN (SELECT student_id FROM fees_record)";
						$result = mysqli_query($conn, $query);
						while ($row = mysqli_fetch_array($result)) {
							echo "<option value='" . $row['student_id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . " (ID: " . $row['student_id'] . ")</option>";
						}
						?>
                </select>
            </div>
            <div class="student-info">
                <img id="student_photo" class="student-photo" src="" alt="Student Photo" />
                <h4 id="student_name"></h4>
            </div>
				<div class="form-group mb-3">
						<label for="total_fees" class="form-label">Total Fees</label>
						<input type="number" class="form-control" id="total_fees" name="total_fees" required oninput="calculateBalance()">
					</div>
					<div class="form-group mb-3">
						<label for="received_fees" class="form-label">Received Fees</label>
						<input type="number" class="form-control" id="received_fees" name="received_fees" required oninput="calculateBalance()">
					</div>
					<div class="form-group mb-3">
						<label for="balance_fees" class="form-label">Balance Fees</label>
						<input type="number" class="form-control" id="balance_fees" name="balance_fees" readonly>
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


            <div class="form-group mb-3">
                <label for="installment_no" class="form-label">Installment Number</label>
                <input type="number" class="form-control" id="installment_no" name="installment_no" required>
            </div>
            <div class="form-group mb-3">
                <label for="amount" class="form-label">Installment Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>
            <div class="form-group mb-3">
                <label for="receive_date" class="form-label">Receive Date</label>
                <input type="date" class="form-control" id="receive_date" name="receive_date">
            </div>
            <div class="form-group mb-3">
                <label for="payment_mode" class="form-label">Payment Mode</label>
                <select class="form-select" id="payment_mode" name="payment_mode" required>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Online">Online</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <button type="submit" name="save_fees" class="btn btn-success w-100">Save</button>
        </form>
    </div>

    <script>
        function fetchStudentInfo(studentId) {
            if (studentId !== '') {
                // Fetch student info using AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `fetch_student_info.php?student_id=${studentId}`, true);
                xhr.onload = function () {
                    if (this.status === 200) {
                        const student = JSON.parse(this.responseText);
                        document.getElementById('student_photo').src = student.photo;
                        document.getElementById('student_name').innerText = student.name;
                    }
                };
                xhr.send();
            }
        }
    </script>
</body>
</html>
