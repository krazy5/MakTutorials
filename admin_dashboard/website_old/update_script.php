<?php
include 'college/database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $rid = $_POST['rid'];
    $received_fees = $_POST['received_fees'];
    $total_fees = $_POST['total_fees'];
    $balance_fees = $total_fees - $received_fees;
    $recieve_date = $_POST['recieve_date'];
    $expected_date = $_POST['expected_date'];
    $std = $_POST['std'];

    // Update the database
    $updateSql = "UPDATE makreciept SET received_fees = '$received_fees', balance_fees = '$balance_fees', recieve_date = '$recieve_date', expected_date = '$expected_date', std = '$std'";

    // Update installment fields
    for ($i = 1; $i <= 10; $i++) {
        $installmentField = 'installment' . $i;
        $installmentValue = isset($_POST[$installmentField]) ? $_POST[$installmentField] : 0;
        $updateSql .= ", $installmentField = '$installmentValue'";
    }

    $updateSql .= " WHERE rid = '$rid'";

    // Uncomment the following lines for database update
    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        echo "Data updated successfully!";
    } else {
        echo "Error updating data: " . mysqli_error($conn);
        echo "Query: $updateSql";
    }
}
?>
