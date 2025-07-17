<?php
header("Content-Type: application/json");

header("Access-Control-Allow-Origin: *"); // Allow requests from any domain
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");




require "../database/config.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $query = "SELECT * FROM enquiry";
    $result = mysqli_query($conn, $query);
    $enquiries = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($enquiries);
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("INSERT INTO enquiry (full_name, contact_number, email, location, course_interested, fees_offered, enquiry_date, status, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssdsss",
        $data['full_name'],
        $data['contact_number'],
        $data['email'],
        $data['location'],
        $data['course_interested'],
        $data['fees_offered'],
        $data['enquiry_date'],
        $data['status'],
        $data['remark']
    );
    $stmt->execute();
    echo json_encode(["message" => "Enquiry created successfully"]);
}  elseif ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['enquiry_id'])) {
        echo json_encode(["error" => "Missing enquiry_id"]);
        http_response_code(400);
        exit();
    }

    $stmt = $conn->prepare("UPDATE enquiry SET full_name=?, contact_number=?, email=?, location=?, course_interested=?, fees_offered=?, enquiry_date=?, status=?, remark=? WHERE enquiry_id=?");

    if (!$stmt) {
        echo json_encode(["error" => "Prepare failed: " . $conn->error]);
        exit();
    }

    $stmt->bind_param(
        "sssssdsssi",
        $data['full_name'],
        $data['contact_number'],
        $data['email'],
        $data['location'],
        $data['course_interested'],
        $data['fees_offered'],
        $data['enquiry_date'],
        $data['status'],
        $data['remark'],
        $data['enquiry_id']
    );

    if ($stmt->execute()) {
        echo json_encode(["message" => "Enquiry updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update enquiry: " . $stmt->error]);
    }

}  elseif ($method === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $stmt = $conn->prepare("DELETE FROM enquiry WHERE enquiry_id=?");
    $stmt->bind_param("i", $data['enquiry_id']);
    $stmt->execute();
    echo json_encode(["message" => "Enquiry deleted successfully"]);
} else {
    echo json_encode(["message" => "Invalid Request"]);
}
?>
