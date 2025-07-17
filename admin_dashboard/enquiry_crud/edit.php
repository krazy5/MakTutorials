<?php
  require "../database/config.php";


// Fetch the enquiry record based on the provided ID
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

// Update enquiry logic
if (isset($_POST['update_enquiry'])) {
    $enquiry_id = mysqli_real_escape_string($conn, $_POST['enquiry_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course_interested = mysqli_real_escape_string($conn, $_POST['course_interested']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);  // New field
    $fees_offered = mysqli_real_escape_string($conn, $_POST['fees_offered']);  // New field
    $remark = mysqli_real_escape_string($conn, $_POST['remark']);  // New field

    // SQL query to update the enquiry
    $update_query = "UPDATE enquiry 
                     SET full_name='$full_name', 
                         contact_number='$contact_number', 
                         email='$email', 
                         course_interested='$course_interested', 
                         location='$location', 
                         fees_offered='$fees_offered', 
                         remark='$remark', 
                         status='$status', 
                         updated_at=NOW() 
                     WHERE enquiry_id='$enquiry_id'";

    // Execute the update query and redirect based on success/failure
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['message'] = "Enquiry updated successfully";
        header("Location: edit.php?id=$enquiry_id");
        exit(0);
    } else {
        $_SESSION['message'] = "Enquiry update failed";
        header("Location: edit.php?id=$enquiry_id");
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

    <title>Edit Enquiry</title>
</head>
<body>
<!-- Navigation Bar -->
        <?php include '../navigation_menu/navigation.php' ?>
<div class="container mt-5">
    <!-- Display success/error messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Enquiry
                        <a href="javascript:void(0);" class="btn btn-danger float-end" onclick="goBack()">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="edit.php?id=<?= $enquiry['enquiry_id']; ?>" method="POST">
                        <input type="hidden" name="enquiry_id" value="<?= $enquiry['enquiry_id']; ?>">

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" name="full_name" value="<?= $enquiry['full_name']; ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" value="<?= $enquiry['contact_number']; ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" value="<?= $enquiry['email']; ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="course_interested" class="form-label">Course Interested</label>
                            <input type="text" name="course_interested" value="<?= $enquiry['course_interested']; ?>" class="form-control" required>
                        </div>

                        <!-- New fields for location, fees offered, and remarks -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" value="<?= $enquiry['location']; ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="fees_offered" class="form-label">Fees Offered</label>
                            <input type="text" name="fees_offered" value="<?= $enquiry['fees_offered']; ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea name="remark" class="form-control"><?= $enquiry['remark']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Pending" <?= $enquiry['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Contacted" <?= $enquiry['status'] === 'Contacted' ? 'selected' : ''; ?>>Contacted</option>
                                <option value="Joined" <?= $enquiry['status'] === 'Joined' ? 'selected' : ''; ?>>Joined</option>
                                <option value="Not Interested" <?= $enquiry['status'] === 'Not Interested' ? 'selected' : ''; ?>>Not Interested</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" name="update_enquiry" class="btn btn-primary">Update Enquiry</button>
                        </div>
                    </form>
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
