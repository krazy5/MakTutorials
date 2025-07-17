<?php include('../database/config.php'); ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM student_record WHERE student_id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: list_student.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
