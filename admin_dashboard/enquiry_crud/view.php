<?php
require '../database/config.php';

// Fetch enquiry details
if (isset($_GET['id'])) {
    $enquiry_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM enquiry WHERE enquiry_id='$enquiry_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $enquiry = mysqli_fetch_array($query_run);
    } else {
        echo "<h4>No Enquiry Found</h4>";
        exit();
    }
}

// Define colors based on status
$status_colors = [
    'Pending' => ['#053fff', '#ade7ff'],
    'Contacted' => ['#f9a825', '#fff9c4'],
    'Joined' => ['#004d40', '#e0f7fa'],
    'Not Interested' => ['#c62828', '#ffccbc']
];

$header_color = $status_colors[$enquiry['status']][0];
$container_color = $status_colors[$enquiry['status']][1];
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <title>View Enquiry</title>
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
        }
        .status-header {
            background-color: <?php echo $header_color; ?>;
            color: white;
        }
        .status-container {
            background-color: <?php echo $container_color; ?>;
            padding: 20px;
            border-radius: 5px;
            color: black;
        }
        .btn-back {
            background-color: #ffffff;
            color: #000000;
            border: none;
        }
    </style>
</head>
<body>
<!-- Navigation Bar -->
        <?php include '../navigation_menu/navigation.php' ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header status-header">
                    <h4>Enquiry Details</h4>
                </div>
                <div class="card-body status-container">
                    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($enquiry['full_name']); ?></p>
                    <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($enquiry['contact_number']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($enquiry['email']); ?></p>
                    <p><strong>Course Interested:</strong> <?php echo htmlspecialchars($enquiry['course_interested']); ?></p>
                    <p><strong>Enquiry Date:</strong> <?php echo htmlspecialchars($enquiry['enquiry_date']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($enquiry['status']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($enquiry['location']); ?></p> <!-- New Column -->
                    <p><strong>Fees Offered:</strong> <?php echo htmlspecialchars($enquiry['fees_offered']); ?></p> <!-- New Column -->
                    <p><strong>Remark:</strong> <?php echo htmlspecialchars($enquiry['remark']); ?></p> <!-- New Column -->
                    <p><strong>Created At:</strong> <?php echo htmlspecialchars($enquiry['created_at']); ?></p>
                    <p><strong>Updated At:</strong> <?php echo htmlspecialchars($enquiry['updated_at']); ?></p>
                    <a href="javascript:void(0);" class="btn btn-back" onclick="goBack()">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function goBack() {
        // Redirect to index.php
        window.open('index.php', '_self');
        // Close the current tab
        window.close();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
