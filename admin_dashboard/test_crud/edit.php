<?php

require '../database/config.php';

// Fetch the test record using the test_id
if (isset($_GET['id'])) {
    $test_id = mysqli_real_escape_string($conn, $_GET['id']);
    $test_query = "SELECT * FROM student_tests WHERE test_id = '$test_id'";
    $test_result = mysqli_query($conn, $test_query);

    if (mysqli_num_rows($test_result) > 0) {
        $test_data = mysqli_fetch_assoc($test_result);
    } else {
        $_SESSION['message'] = "No such test record found.";
        $_SESSION['message_type'] = "danger"; // Error type
        header("Location: index.php");
        exit(0);
    }
}

// Fetch student names for the dropdown
$students_query = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS student_name FROM student_record";
$students_result = mysqli_query($conn, $students_query);

// Update the test record
if (isset($_POST['update'])) {
    // Get form data
    $studentId = mysqli_real_escape_string($conn, $_POST['student_id']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $marksObtained = mysqli_real_escape_string($conn, $_POST['marks_obtained']);
    $totalMarks = mysqli_real_escape_string($conn, $_POST['total_marks']);
    $testDate = mysqli_real_escape_string($conn, $_POST['test_date']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);

    // Validation: Marks obtained cannot be greater than total marks
    if ($marksObtained > $totalMarks) {
        $_SESSION['message'] = "Marks obtained cannot be greater than total marks.";
        $_SESSION['message_type'] = "danger"; // Error type
        header("Location: edit.php?id=$test_id");
        exit(0);
    }

    // Calculate percentage
    $percentage = ($marksObtained / $totalMarks) * 100;

    // Calculate is_passed and grade
    $isPassed = ($percentage >= 35) ? 1 : 0; // Pass percentage is 35%
    $grade = '';

    // Grade calculation logic
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
        $_SESSION['message_type'] = "danger"; // Error type
        header("Location: edit.php?id=$test_id");
        exit(0);
    }

    $target_file = $test_data['test_file']; // Keep the existing file unless a new one is uploaded

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

        // Check if file is a valid format
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        if (!in_array($fileType, $allowed_types)) {
            $_SESSION['message'] = "Only JPG, JPEG, PNG, GIF, & PDF files are allowed.";
            $_SESSION['message_type'] = "danger"; // Error type
            header("Location: edit.php?id=$test_id");
            exit(0);
        }

        // Limit file size (e.g., 2MB max)
        if ($_FILES["attachment"]["size"] > 2000000) {
            $_SESSION['message'] = "Sorry, your file is too large. Max 2MB allowed.";
            $_SESSION['message_type'] = "danger"; // Error type
            header("Location: edit.php?id=$test_id");
            exit(0);
        }

        // Move the file
        if (!move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
            $_SESSION['message'] = "Sorry, there was an error uploading the file.";
            $_SESSION['message_type'] = "danger"; // Error type
            header("Location: edit.php?id=$test_id");
            exit(0);
        }
    }

    // Update the test record in the database
    $update_query = "UPDATE student_tests SET student_id='$studentId', subject='$subject', marks_obtained='$marksObtained', total_marks='$totalMarks', percentage='$percentage', test_date='$testDate', remarks='$remarks', test_file='$target_file', is_passed='$isPassed', grade='$grade' WHERE test_id='$test_id'";
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['message'] = "Test record updated successfully!";
        $_SESSION['message_type'] = "success"; // Success type
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Database error: Could not update record.";
        $_SESSION['message_type'] = "danger"; // Error type
        header("Location: edit.php?id=$test_id");
        exit(0);
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Test Record</title>

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
</head>
<body>
    <!-- Navigation Bar -->
        <?php include '../navigation_menu/navigation.php' ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h4>Edit Test Record
                        <a href="index.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="edit.php?id=<?= $test_id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student Name</label>
                            <select name="student_id" class="form-select" required>
                                <?php while ($student = mysqli_fetch_assoc($students_result)) : ?>
                                    <option value="<?= $student['student_id']; ?>" <?= $student['student_id'] == $test_data['student_id'] ? 'selected' : '' ?>>
                                        <?= $student['student_name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" value="<?= $test_data['subject']; ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="marks_obtained" class="form-label">Marks Obtained</label>
                                    <input type="number" name="marks_obtained" class="form-control" value="<?= $test_data['marks_obtained']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="total_marks" class="form-label">Total Marks</label>
                                    <input type="number" name="total_marks" class="form-control" value="<?= $test_data['total_marks']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="test_date" class="form-label">Test Date</label>
                            <input type="date" name="test_date" class="form-control" value="<?= $test_data['test_date']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="4"><?= $test_data['remarks']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attachment (Optional: PDF/Image)</label>
                            <input type="file" name="attachment" class="form-control">
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" name="update" class="btn btn-primary">Update Test Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
