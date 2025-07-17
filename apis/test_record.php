<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../database/config.php";


// Get the action type from the request (Use $_POST for insert/update, $_GET for fetch)
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action == "fetch") {
    fetchTestRecord($conn);
} elseif ($action == "insert") {
    insertFeesChart($conn);
} elseif ($action == "update") {
    updateFeesChart($conn);
} elseif ($action == "delete") {
    deleteFeesChart($conn);
} else {
    echo json_encode(["error" => "Invalid action"]);
}

$conn->close();

function fetchTestRecord($conn) {
    $tests = array(); // Ensure we always return an array

    $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';
    $subject = isset($_GET['subject']) ? $_GET['subject'] : '';

    $sql = "SELECT * FROM student_tests WHERE student_id = '$student_id'";

    if (!empty($subject)) {
        $sql .= " AND subject LIKE '%$subject%'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tests[] = $row;
        }
    }

    echo json_encode($tests); // Always return an array
}



?>