<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Enquiry Details</title>
    <style>
    .fix {
        position: sticky;
        background: white;
    }
    .fix:first-child {
        left: 0;
        width: 180px;
        background-color: #f2f2f0;
    }
    .fix:last-child {
        right: 0;
        width: 120px;
        background-color: #f2f2f0;
    }
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .status-pending {
        background-color: #ade7ff;
    }
    .status-contacted {
        background-color: #fff9c4;
    }
    .status-joined {
        background-color: #e0f7fa;
    }
    .status-notinterested {
        background-color: #ffccbc;
    }
    </style>
</head>
<body>
      <!-- Navigation Bar -->
    <?php include '../navigation_menu/navigation.php' ?>
    <div class="container mt-4">

        <!-- Optional: Include message alerts for success/error actions -->
        <!-- <?php include('message.php'); ?> -->
<?php
    
  require "../database/config.php";

    // Get selected filter from the dropdown
    $selectedStatus = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'All';

    // Query to fetch data based on filter
    if ($selectedStatus == 'All') {
        $query = "SELECT * FROM enquiry";
    } else {
        $query = "SELECT * FROM enquiry WHERE status = '$selectedStatus'";
    }
    
    $query_run = mysqli_query($conn, $query);
?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Enquiry Details
                            <a href="create.php" class="btn btn-primary float-end" target="_blank">Request Enquiry</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <form method="GET" class="form-inline">
                                <label for="status_filter" class="me-2">Filter by Status:</label>
                                <select name="status_filter" id="status_filter" class="form-select w-auto" onchange="this.form.submit()">
                                    <option value="All" <?= $selectedStatus == 'All' ? 'selected' : '' ?>>All</option>
                                    <option value="Pending" <?= $selectedStatus == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Contacted" <?= $selectedStatus == 'Contacted' ? 'selected' : '' ?>>Contacted</option>
                                    <option value="Joined" <?= $selectedStatus == 'Joined' ? 'selected' : '' ?>>Joined</option>
                                    <option value="Not Interested" <?= $selectedStatus == 'Not Interested' ? 'selected' : '' ?>>Not Interested</option>
                                </select>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="fix">Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Course Interested</th>
                                        <th>Location</th> <!-- Added column -->
                                        <th>Fees Offered</th> <!-- Added column -->
                                        <th>Status</th>
                                        <th>Remark</th> <!-- Added column -->
                                        <th class="fix">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if ($query_run === false) {
                                            // Display error message if query fails
                                            echo "<h5>Error: " . mysqli_error($conn) . "</h5>";
                                        } else if (mysqli_num_rows($query_run) > 0) {
                                            foreach($query_run as $enquiry) {
                                                // Status color assignment
                                                $statusClass = '';
                                                if ($enquiry['status'] == 'Pending') {
                                                    $statusClass = 'status-pending';
                                                } elseif ($enquiry['status'] == 'Contacted') {
                                                    $statusClass = 'status-contacted';
                                                } elseif ($enquiry['status'] == 'Joined') {
                                                    $statusClass = 'status-joined';
                                                } elseif ($enquiry['status'] == 'Not Interested') {
                                                    $statusClass = 'status-notinterested';
                                                }
                                                ?>
                                                <tr class="<?= $statusClass ?>">
                                                    <td class="fix"><?= $enquiry['enquiry_date']; ?></td>
                                                    <td><?= $enquiry['full_name']; ?></td>
                                                    <td><?= $enquiry['email']; ?></td>
                                                    <td><?= $enquiry['contact_number']; ?></td>
                                                    <td><?= $enquiry['course_interested']; ?></td>
                                                    <td><?= $enquiry['location']; ?></td> <!-- New data -->
                                                    <td><?= $enquiry['fees_offered']; ?></td> <!-- New data -->
                                                    <td><?= $enquiry['status']; ?></td>
                                                    <td><?= $enquiry['remark']; ?></td> <!-- New data -->
                                                    <td class="fix">
                                                        <a href="view.php?id=<?= $enquiry['enquiry_id']; ?>" class="btn btn-info btn-sm" target="_blank">View</a>
                                                        <a href="edit.php?id=<?= $enquiry['enquiry_id']; ?>" class="btn btn-warning btn-sm" target="_blank">Edit</a>

                                                        <form action="code.php" method="POST" onsubmit="return confirmDelete();">
                                                                <input type="hidden" name="delete_enquiry" value="<?= $enquiry['enquiry_id']; ?>">
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo "<h5>No Record Found</h5>";
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this enquiry? This action cannot be undone.');
}
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            location.reload();
        }
    });

</script>

</body>
</html>
