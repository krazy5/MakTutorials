<?php include('../database/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-wrapper {
            margin: 50px auto;
            width: 100%;
            max-width: 1200px;
        }
        .table-title {
            padding-bottom: 15px;
            background: #343a40;
            color: #fff;
            padding: 16px 30px;
            margin: -20px -31px 10px;
            border-radius: 3px 3px 0 0;
        }
        .table-responsive {
            margin: 30px 0;
        }
    </style>
</head>
<body>

<div class="container table-wrapper">
    <div class="table-title">
        <h2>Manage <b>Students</b></h2>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Roll No</th>
                    <th>Batch Name</th>
                    <th>Mobile No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM student_record");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['roll_no'] . "</td>";
                        echo "<td>" . $row['batch_name'] . "</td>";
                        echo "<td>" . $row['mobile_no'] . "</td>";
                        echo "<td>
							<a href='view_student.php?id=" . $row['student_id'] . "' class='view'><i class='fa fa-view'>view</i></a>
                            <a href='edit_student.php?id=" . $row['student_id'] . "' class='edit'><i class='fa fa-edit'>edit</i></a>
                            <a href='delete_student.php?id=" . $row['student_id'] . "' class='delete'><i class='fa fa-trash'>delete</i></a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
