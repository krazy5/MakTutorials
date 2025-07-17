<?php
header("Content-Type: application/json");
require "../database/config.php";

// Get the action type from the request (Use $_POST for insert/update, $_GET for fetch)
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action == "fetch") {
    fetchFeesChart($conn);
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

// Function to fetch all fee records
function fetchFeesChart($conn) {
    $sql = "SELECT * FROM fees_chart";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $fees = [];
        while ($row = $result->fetch_assoc()) {
            $fees[] = $row;
        }
        echo json_encode($fees);
    } else {
        echo json_encode([]);
    }
}

// Function to insert a new fee record
function insertFeesChart($conn) {
    file_put_contents("log.txt", print_r($_POST, true), FILE_APPEND); // Debugging log

    if (!isset($_POST['board_exam'], $_POST['std'], $_POST['yearly_fees'], $_POST['monthly_fees'], $_POST['remarks'], $_POST['subject'])) {
        echo json_encode(["error" => "Missing parameters"]);
        return;
    }

    $board_exam = $conn->real_escape_string($_POST['board_exam']);
    $std = $conn->real_escape_string($_POST['std']);
    $yearly_fees = (double) $_POST['yearly_fees'];
    $monthly_fees = (double) $_POST['monthly_fees'];
    $remarks = $conn->real_escape_string($_POST['remarks']);
    $subject = $conn->real_escape_string($_POST['subject']);

    $sql = "INSERT INTO fees_chart (board_exam, std, yearly_fees, monthly_fees, remarks, subject) 
            VALUES ('$board_exam', '$std', $yearly_fees, $monthly_fees, '$remarks', '$subject')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => "Record inserted successfully", "fc_id" => $conn->insert_id]);
    } else {
        echo json_encode(["error" => "Insert failed: " . $conn->error]);
    }
}

// Function to update a fee record
function updateFeesChart($conn) {
    file_put_contents("log.txt", print_r($_POST, true), FILE_APPEND); // Debugging log

    if (!isset($_POST['fc_id'], $_POST['board_exam'], $_POST['std'], $_POST['yearly_fees'], $_POST['monthly_fees'], $_POST['remarks'], $_POST['subject'])) {
        echo json_encode(["error" => "Missing parameters"]);
        return;
    }

    $fc_id = (int) $_POST['fc_id'];
    $board_exam = $conn->real_escape_string($_POST['board_exam']);
    $std = $conn->real_escape_string($_POST['std']);
    $yearly_fees = (double) $_POST['yearly_fees'];
    $monthly_fees = (double) $_POST['monthly_fees'];
    $remarks = $conn->real_escape_string($_POST['remarks']);
    $subject = $conn->real_escape_string($_POST['subject']);

    $sql = "UPDATE fees_chart SET 
                board_exam='$board_exam', 
                std='$std', 
                yearly_fees=$yearly_fees, 
                monthly_fees=$monthly_fees, 
                remarks='$remarks', 
                subject='$subject' 
            WHERE fc_id=$fc_id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => "Record updated successfully"]);
    } else {
        echo json_encode(["error" => "Error: " . $conn->error]);
    }
}

// Function to delete a fee record
function deleteFeesChart($conn) {
    file_put_contents("log.txt", print_r($_POST, true), FILE_APPEND); // Debugging log

    $fc_id = isset($_POST['fc_id']) ? (int) $_POST['fc_id'] : 0;

    if ($fc_id == 0) {
        echo json_encode(["error" => "Invalid ID"]);
        return;
    }

    $sql = "DELETE FROM fees_chart WHERE fc_id=$fc_id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => "Record deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error: " . $conn->error]);
    }
}
?>
