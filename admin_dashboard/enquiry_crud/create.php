<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Request Enquiry</title>
    <style>
        .form-container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
 <!-- Navigation Bar -->
    <?php include '../navigation_menu/navigation.php' ?>

 <!-- Optional: Include message alerts for success/error actions -->
    <?php include('message.php'); ?>

    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                   <h4>Request Enquiry
                       <a href="javascript:void(0);" class="btn btn-danger float-end" onclick="goBack()">Back</a>
                   </h4>
                </div>

                <div class="card-body">
                    <form action="code.php" method="POST">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="course_interested" class="form-label">Course Interested</label>
                            <input type="text" name="course_interested" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" class="form-control"> <!-- New field -->
                        </div>

                        <div class="mb-3">
                            <label for="fees_offered" class="form-label">Fees Offered</label>
                            <input type="text" name="fees_offered" class="form-control"> <!-- New field -->
                        </div>

                        <div class="mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea name="remark" class="form-control"></textarea> <!-- New field -->
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Pending">Pending</option>
                                <option value="Contacted">Contacted</option>
                                <option value="Joined">Joined</option>
                                <option value="Not Interested">Not Interested</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" name="save_enquiry" class="btn btn-primary">Submit Enquiry</button>
                        </div>
                    </form>
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
