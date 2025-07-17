<?php

require '../database/config.php';

// Fetch distinct student names for the dropdown filter
$students_query = "SELECT student_id, first_name, last_name FROM student_record";
$students_result = mysqli_query($conn, $students_query);

$selected_student_id = isset($_GET['student_id']) ? $_GET['student_id'] : 'ALL';


// Display message if it exists in the session
if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    // Unset the message after displaying it
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
endif;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Student Test Records</title>
    <style>
    .fix {
        position: sticky;
        background: white;
    }
    .fix:first-child {
        left:0;
        width:150px;
        background-color: #f2f2f2;
    }
    .fix:last-child {
        right:0;
        width:180px;
        background-color: #f2f2f2;
    }
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .btn-sm {
        margin: 0 5px;
    }
    .btn-info, .btn-success, .btn-danger {
        padding: 4px 12px;
    }
    .btn-info i, .btn-success i, .btn-danger i {
        margin-right: 4px;
    }
    .card-header {
        background-color: #007bff;
        color: white;
    }
    .dropdown-filter {
        margin-bottom: 15px;
    }
    </style>
  </head>
  <body>
        <!-- Navigation Bar -->
        <?php include '../navigation_menu/navigation.php' ?>
    <div class="container mt-4">
        <!-- Dropdown filter for student name -->
        <div class="row dropdown-filter">
            <div class="col-md-12">
                <form method="GET" action="">
                    <label for="student_id" class="form-label">Filter by Student:</label>
                    <select name="student_id" id="student_id" class="form-select" onchange="this.form.submit()">
                        <option value="ALL" <?= $selected_student_id == 'ALL' ? 'selected' : '' ?>>ALL</option>
                        <?php
                        if(mysqli_num_rows($students_result) > 0) {
                            while($student = mysqli_fetch_assoc($students_result)) {
                                $selected = $selected_student_id == $student['student_id'] ? 'selected' : '';
                                echo "<option value='{$student['student_id']}' $selected>{$student['first_name']} {$student['last_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </form>
            </div>
        </div>

        <!-- Display filtered records -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
						<h4>Student Test Records
							<a href="add_test.php" class="btn btn-light float-end ms-2" target="_blank">Add Test Record</a>
							<a href="performance.php" class="btn btn-light float-end" target="_blank">See Performance</a>
						</h4>
					</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="fix">Student Name</th>
                                        <th>Subject</th>
                                        <th>Marks Obtained</th>
                                        <th>Total Marks</th>
                                        <th>Percentage</th>
                                        <th>Test Date</th>
                                        <th>Grade</th>
                                        <th class="fix">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        // Modify the query to filter by selected student
                                        $query = "SELECT sr.first_name, sr.last_name, st.test_id, st.subject, st.marks_obtained, st.total_marks, st.percentage, st.test_date, st.grade
                                                  FROM student_tests st
                                                  JOIN student_record sr ON st.student_id = sr.student_id";
                                        
                                        if ($selected_student_id != 'ALL') {
                                            $query .= " WHERE sr.student_id = '$selected_student_id'";
                                        }

                                        $query_run = mysqli_query($conn, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $record)
                                            {
                                                ?>
                                                <tr>
                                                    <td class="fix"><?= htmlspecialchars($record['first_name']) . ' ' . htmlspecialchars($record['last_name']); ?></td>
                                                    <td><?= htmlspecialchars($record['subject']); ?></td>
                                                    <td><?= htmlspecialchars($record['marks_obtained']); ?></td>
                                                    <td><?= htmlspecialchars($record['total_marks']); ?></td>
                                                    <td><?= round($record['percentage'], 2); ?>%</td>
                                                    <td><?= htmlspecialchars($record['test_date']); ?></td>
                                                    <td><?= htmlspecialchars($record['grade']); ?></td>
                                                    <td class="fix">
                                                        <a href="view.php?test_id=<?= urlencode($record['test_id']); ?>" class="btn btn-info btn-sm" target="_blank">
															<i class="fas fa-eye"></i> View
														</a>
                                                        <a href="edit.php?id=<?= urlencode($record['test_id']); ?>" class="btn btn-success btn-sm">
															<i class="fas fa-edit"></i> Edit
														</a>


                                                        <a href="delete_test.php?test_id=<?= urlencode($record['test_id']); ?>" 
                                                           class="btn btn-danger btn-sm" 
                                                           onclick="return confirmDelete('<?= htmlspecialchars($record['subject'], ENT_QUOTES, 'UTF-8'); ?>');" >
                                                           <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            echo "<tr><td colspan='8' class='text-center'>No Record Found</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="image-overlay">
        <span id="close-btn" onclick="hideImage()">×</span>
        <img id="full-image" src="">
    </div>

    <script>
        function showImage(src) {
            document.getElementById('full-image').src = src;
            document.getElementById('full-image').style.display = 'block';
            document.getElementById('image-overlay').style.display = 'block';
        }

        function hideImage() {
            document.getElementById('full-image').style.display = 'none';
            document.getElementById('image-overlay').style.display = 'none';
        }

        function confirmDelete(subject) {
            return confirm("Are you sure you want to delete the test record for subject: " + subject + "?");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </body>
</html>
