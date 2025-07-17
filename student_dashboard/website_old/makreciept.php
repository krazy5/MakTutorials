<?php
include 'college/database.php';
$searchErr = '';
$employee_details = '';
if (isset($_POST['save'])) {
    
    if (!empty($_POST['search'])) {
        $search = $_POST['search'];
        $sql = "SELECT * FROM makreciept WHERE rid LIKE '%$search%' OR full_name LIKE '%$search%'";
        $result = mysqli_query($conn, $sql);
    } else {
        echo "inside save";
        $searchErr = "Please enter the information";
    }
}

if (isset($_POST['submit'])) {
    $rid = $_POST['rid'];
    $received_fees = $_POST['received_fees'];
    $total_fees = $_POST['total_fees'];
    $balance_fees = $total_fees - $received_fees;
    $recieve_date = $_POST['recieve_date'];
    $expected_date = $_POST['expected_date'];
    $std = $_POST['std'];

    $updateSql = "UPDATE makreciept SET recieved_fees = '$received_fees', balance_fees = '$balance_fees', recieve_date = '$recieve_date', expected_date = '$expected_date', std = '$std' WHERE rid = '$rid'";
    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        echo "Data updated successfully!";
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
}
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <title>MAK RECEIPT</title>
    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body{
            background: url(bg.jpeg);
        }
        form{
            box-shadow: 2px 6px 100px #ffffff;
        }
    </style>
  </head>

<body>

   <div class="container-fluid bg-dark text-light py-3">
       <header class="text-center">
           <h1 class="display-6">MAK RECEIPT</h1>
       </header>
   </div>

   <div class="container_fluid  ">
    <form class="form-horizontal text-center" action="#" method="post">
        <div class="row">
            <div class="form-group col-md-6 offset-md-3">
                <label class="control-label" for="search"><b>Search Certificate Information:</b></label>
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="search here">
                    <button type="submit" name="save" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <span class="error" style="color:red;">* <?php echo $searchErr;?></span>
        </div>
    </form>
 
    <br/><br/>
    
    <?php
    if (isset($result) && mysqli_num_rows($result) > 0) {
        ?>
        <h3><u>Search Result</u></h3><br/>
        <?php
        while ($value = mysqli_fetch_assoc($result)) {
            ?>
            <section class="container my-2 bg-dark w-50 text-light p-2">
                <form class="row g-3 p-3" method="post" action="#">
                    <div class="col-md-4">
                        <label for="rid" class="form-label">RID</label>
                        <input type="text" class="form-control" id="rid" name="rid" value="<?php echo $value['rid']; ?>" readonly>
                    </div>
                    <div class="col-md-8">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" value="<?php echo $value['full_name'];?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="total_fees" class="form-label">Total Fees</label>
                        <input type="number" class="form-control" id="total_fees" name="total_fees" value="<?php echo $value['total_fees'];?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="balance_fees" class="form-label">Balance Fees</label>
                        <input type="number" class="form-control" id="balance_fees" name="balance_fees" value="<?php echo $value['balance_fees'];?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="received_fees" class="form-label">Fees Received</label>
                        <input type="number" class="form-control" id="received_fees" name="received_fees" value="<?php echo $value['installment1'];?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="recieve_date" class="form-label">Receive Date</label>
                        <input type="date" class="form-control" id="recieve_date" name="recieve_date" value="<?php echo $value['recieve_date'];?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="expected_date" class="form-label">Expected Date</label>
                        <input type="date" class="form-control" id="expected_date" name="expected_date" value="<?php echo $value['expected_date'];?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="std" class="form-label">Std</label>
                        <input type="text" class="form-control" id="std" name="std" value="<?php echo $value['std'];?>" readonly>
                    </div>
                    <!-- Installment Fields -->
                    <!-- ... (your existing code) ... -->

<?php for ($i = 1; $i <= min(3, count($value)); $i++) { ?>
    <div class="col-md-6">
        <label for="installment<?php echo $i; ?>" class="form-label">Installment <?php echo $i; ?></label>
        <input type="number" class="form-control" id="installment<?php echo $i; ?>" name="installment<?php echo $i; ?>" value="<?php echo $value['installment'.$i]; ?>" readonly>
    </div>
<?php } ?>

<div class="col-md-12" id="moreInstallments" style="display: none;">
    <!-- Display additional installments here -->
    <?php for ($i = 4; $i <= 10; $i++) { ?>
        <div class="col-md-6">
            <label for="installment<?php echo $i; ?>" class="form-label">Installment <?php echo $i; ?></label>
            <input type="number" class="form-control" id="installment<?php echo $i; ?>" name="installment<?php echo $i; ?>" value="<?php echo $value['installment'.$i]; ?>" readonly>
        </div>
    <?php } ?>
</div>

<div class="col-md-12 mt-2">
    <a href="#" id="showMoreLink">Show More</a>
    <a href="#" id="hideMoreLink" style="display: none;">Hide</a>
</div>

<script>
    document.getElementById("showMoreLink").addEventListener("click", function (e) {
        e.preventDefault();
        document.getElementById("moreInstallments").style.display = "block";
        this.style.display = "none";
        document.getElementById("hideMoreLink").style.display = "inline";
    });

    document.getElementById("hideMoreLink").addEventListener("click", function (e) {
        e.preventDefault();
        document.getElementById("moreInstallments").style.display = "none";
        this.style.display = "none";
        document.getElementById("showMoreLink").style.display = "inline";
    });
</script>

<!-- ... (your existing code) ... -->

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="submit" id="submitButton" disabled>Submit</button>
                        <button type="button" class="btn btn-secondary" id="editButton">Edit</button>
                    </div>
                </form>
            </section>
        <?php
        }
    } else {
        echo "0 results";
    }
    ?>
    </div>
</div>
<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ldFsg5Rr6PeH5R5lPpnh4Z6fMX2H4JcXcYKZcdCZ1YsGfhpE9bSrGz7RjsMhJT8P" crossorigin="anonymous"></script>

<script>
    // JavaScript for handling edit button click
    document.getElementById("editButton").addEventListener("click", function() {
        document.getElementById("received_fees").readOnly = false;
        document.getElementById("total_fees").readOnly = false;
        document.getElementById("balance_fees").readOnly = false;
        document.getElementById("recieve_date").readOnly = false;
        document.getElementById("expected_date").readOnly = false;
        document.getElementById("std").readOnly = false;
        document.getElementById("submitButton").disabled = false;
         // Make installment fields editable
        for (let i = 1; i <= 10; i++) {
            document.getElementById("installment" + i).readOnly = false;
        }
    });
    
</script>

<script src="jquery-3.2.1.min.js"></script>
<script src="bootstrap.min.js"></script>
</body>
</html>
