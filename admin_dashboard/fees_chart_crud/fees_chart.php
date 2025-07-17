<!doctype html>
<html lang="en">
<head>
    <title>Mak Tutorials</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        .card { margin: 20px; }
        .navbar { margin-bottom: 20px; }
        .card-header { font-weight: bold; }
        .search-bar { margin: 20px 0; }
        body {
            background: linear-gradient(45deg, #ce1e53, #8f00c7);
            min-height: 100vh;
        }
    </style>    
</head>
<body class="bg-warning">
    <!-- Navigation Bar -->
    
 <?php include('message.php'); ?>
    <!-- Search Bar -->
    <div class="container-fluid search-bar">
	
           <a  href="fc_create.php" class="btn btn-primary" target="_blank" type="add">Add Fees </a>
 
        <form method="GET" action="" class="d-flex justify-content-center">
            <input class="form-control me-2 w-50" type="search" name="search" placeholder="Search by student name or class" aria-label="Search">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div>

    <main>
        <div class="container-fluid px-2">
            <div class="row ">
                <?php 
                error_reporting(0);
                session_start();
                include "../database/config.php";

                // Check if search term is set
                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // Modify query to include search term
                $query = "SELECT * FROM fees_chart WHERE board_exam LIKE '%$search%' OR subject LIKE '%$search%' OR std LIKE '%$search%'";

                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0) {
                    echo "<div class='container'><div class='row justify-content-center align-items-center g-1'>";
                    while ($rows = mysqli_fetch_array($result)) {
                        ?>
                        <div class='card col-md-6 col-lg-4 col-xl-3 m-3 p-2' style='max-width: 18rem;'>
                          
                            <div class='card-body'>
                                <h4 class='card-title fw-bolder text-uppercase'><?=$rows['board_exam']?></h4>
                                <p class='card-text fw-bold'>STD :- <?=$rows['std']?></p>
                                <p class='card-text fw-bold'>yearly_fees :- <?=$rows['yearly_fees']?></p>
                                <p class='card-text fw-bold'>monthly_fees :- <?=$rows['monthly_fees']?></p>
                                <p class='card-text fw-bold'>subject :- <?=$rows['subject']?></p>
                                <p class='card-text fw-bold'>School/college :- <?=$rows['remarks']?></p>
                               <!-- <a class='btn btn-primary mx-1' href="student-view.php?id=<?=$rows['student_id'];?>" role='button'>Details</a>-->
                                <a class='btn btn-warning mx-1' href="fc_edit.php?id=<?=$rows['fc_id'];?>" target="_blank" role='button'>Edit</a>
                                
								<form action="code.php" method="POST" class="d-inline"  onsubmit="return confirmDelete()">
                                  <button type="submit" name="delete_fc" value="<?=$rows['fc_id'];?>" class="btn btn-danger mx-1 ">Delete</button>
                                </form>
                            </div>
                        </div>"
                    <?php } ?>
                    </div></div>
              <?php  } 
			  else {
                    echo "<p class='text-center' style='color:white'>No records found...</p>";
                }
                ?>
            </div>
        </div>
    </main>
<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this student?");
}
document.addEventListener('visibilitychange', function() {
		if (document.visibilityState === 'visible') {
			location.reload();
		}
	});
 document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            location.reload();
        }
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
