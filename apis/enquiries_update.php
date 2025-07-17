<?php
header("Content-Type: application/json");
require "../database/config.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
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

} elseif ($method === 'GET') {
    parse_str(file_get_contents("php://input"), $data);
    $stmt = $conn->prepare("DELETE FROM enquiry WHERE enquiry_id=?");
    $stmt->bind_param("i", $data['delete_id']);
    $stmt->execute();
    echo json_encode(["message" => "Enquiry deleted successfully"]);
} else {
    echo json_encode(["message" => "Invalid Request"]);
}  
?>
