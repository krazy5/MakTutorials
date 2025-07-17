<?php

require '../database/config.php';

// Fetch student names for the dropdown
$students_query = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS student_name FROM student_record";
$students_result = mysqli_query($conn, $students_query);

if (isset($_POST['submit'])) {
    // Get form data
    $studentId = mysqli_real_escape_string($conn, $_POST['student_id']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $marksObtained = mysqli_real_escape_string($conn, $_POST['marks_obtained']);
    $totalMarks = mysqli_real_escape_string($conn, $_POST['total_marks']);
    $testDate = mysqli_real_escape_string($conn, $_POST['test_date']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    
    // Server-side validation to check if marks obtained are greater than total marks
    if ($marksObtained > $totalMarks) {
        $_SESSION['message'] = "Marks obtained cannot be greater than total marks.";
        header("Location: add_test.php");
        exit(0);
    }

    // Calculate percentage
    $percentage = ($marksObtained / $totalMarks) * 100;

    // Calculate is_passed and grade
    $isPassed = ($percentage >= 35) ? 1 : 0; // Pass percentage is now 35%
    $grade = '';

    // Updated grade calculation logic
    if ($percentage >= 80) {
        $grade = 'A';
    } elseif ($percentage >= 70) {
        $grade = 'B';
    } elseif ($percentage >= 60) {
        $grade = 'C';
    } elseif ($percentage >= 50) {
        $grade = 'D';
    } elseif ($percentage >= 35) {
        $grade = 'E';
    } else {
        $grade = 'F';
    }

    // Validation: Prevent future test dates
    if ($testDate > date('Y-m-d')) {
        $_SESSION['message'] = "Test date cannot be in the future.";
        header("Location: add_test.php");
        exit(0);
    }

    $target_file = null; // Set default for the file upload as optional

    // Handle file upload if exists
    if (!empty($_FILES["attachment"]["name"])) {
        $target_dir = "uploads/";

        // Generate a unique file name using the current timestamp and a unique ID
        $fileName = uniqid() . '_' . time();
        
        // Sanitize the filename
        $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $fileName);  // Replace invalid characters with underscores
        
        // Get file extension
        $fileType = strtolower(pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $fileName . '.' . $fileType;

        // Check if a file with the same name already exists in the uploads directory (highly unlikely with the unique filename)
        if (file_exists($target_file)) {
            $_SESSION['message'] = "A record with the same file name already exists. This record already exists.";
            header("Location: add_test.php");
            exit(0);
        }

        // Validation: Check if file is a valid format
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        if (!in_array($fileType, $allowed_types)) {
            $_SESSION['message'] = "Only JPG, JPEG, PNG, GIF, & PDF files are allowed.";
            header("Location: add_test.php");
            exit(0);
        }

        // Limit file size (e.g., 2MB max)
        if ($_FILES["attachment"]["size"] > 2000000) {
            $_SESSION['message'] = "Sorry, your file is too large. Max 2MB allowed.";
            header("Location: add_test.php");
            exit(0);
        }

        // If validation passes, move the file
        if (!move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
            $_SESSION['message'] = "Sorry, there was an error uploading the file.";
            header("Location: add_test.php");
            exit(0);
        }
    }

    // Insert data into the database (including the percentage)
    $query = "INSERT INTO student_tests (student_id, subject, marks_obtained, total_marks, percentage, test_date, remarks, test_file, is_passed, grade) 
              VALUES ('$studentId', '$subject', '$marksObtained', '$totalMarks', '$percentage', '$testDate', '$remarks', '$target_file', '$isPassed', '$grade')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Test record added successfully!";
        header("Location: add_test.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Database error: Could not insert record.";
        header("Location: add_test.php");
        exit(0);
    }
}
?>

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
                    <form action="add_test.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student Name</label>
                            <select name="student_id" class="form-select" required>
                                <option value="" selected disabled>Select Student</option>
                                <?php while ($student = mysqli_fetch_assoc($students_result)) : ?>
                                    <option value="<?= $student['student_id']; ?>">
                                        <?= $student['student_name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
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
                            <button type="submit" name="submit" class="btn btn-primary">Save Test Record</button>
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
