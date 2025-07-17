

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for additional styling -->
    <style>
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #0069d9;
            border-color: #005cbf;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        body {
            background-color: #f8f9fa;
        }
    </style>

    <title>Add Test Record</title>
</head>
<body>
    <!-- Navigation Bar -->
    <?php include '../navigation_menu/navigation.php' ?>

    <?php
require '../database/config.php';


// Get the mobile number from the session
$mobile = $_SESSION['student'];

// Fetch student details based on mobile number
$student_query = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS student_name FROM student_record WHERE mobile_no = ?";
$stmt = $conn->prepare($student_query);
$stmt->bind_param("s", $mobile);
$stmt->execute();
$student_result = $stmt->get_result();
$student = $student_result->fetch_assoc();

// Check if student was found based on mobile number
if (!$student) {
    echo "Student not found";
    exit;
}

$studentId = $student['student_id'];
$studentName = $student['student_name'];
?>

    <?php include('message.php'); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h4>Add Test Record
                            <a href="javascript:void(0)" class="btn btn-danger float-end" onclick="goBack()">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="student_name" class="form-label">Student Name</label>
                                <input type="text" name="student_name" class="form-control" value="<?= $studentName; ?>" readonly>
                                <input type="hidden" name="student_id" value="<?= $studentId; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="marks_obtained" class="form-label">Marks Obtained</label>
                                        <input type="number" name="marks_obtained" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="total_marks" class="form-label">Total Marks</label>
                                        <input type="number" name="total_marks" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="test_date" class="form-label">Test Date</label>
                                <input type="date" name="test_date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachment (Optional: PDF/Image)</label>
                                <input type="file" name="attachment" class="form-control">
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" name="save_test" class="btn btn-primary">Save Test Record</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Client-side validation script -->
    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const marksObtained = parseFloat(document.querySelector('input[name="marks_obtained"]').value);
            const totalMarks = parseFloat(document.querySelector('input[name="total_marks"]').value);

            if (marksObtained > totalMarks) {
                alert('Marks obtained cannot be greater than total marks.');
                event.preventDefault();  // Prevent the form from submitting
            }
        });

        function goBack() {
            // Redirect to index.php
            window.open('index.php', '_self');
            // Close the current tab
            window.close();
        }
    </script>
</body>
</html>
