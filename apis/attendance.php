<?php
require "../database/config.php";

// Get the action type from the request (Use $_POST for insert/update, $_GET for fetch)
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action == "fetch") {
    fetchAttendance($conn);
} elseif ($action == "update") {
    insertUpdteAttendance($conn);
}else if($action=="fetch_summary"){
    fetchAttendanceSummary($conn);
} else {
    echo json_encode(["error" => "Invalid action"]);
}


function fetchAttendanceSummary($conn) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get POST data
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $studentId = isset($_POST['student_id']) ? $_POST['student_id'] : '';
        $date = isset($_POST['date']) ? $_POST['date'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        // Validate required fields
        if (empty($studentId)) {
            echo json_encode(["success" => false, "message" => "Student ID is required"]);
            return;
        }

        // Query to fetch the total count of each attendance status for the specified student
        $query = "SELECT 
                        SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) AS present_count,
                        SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END) AS absent_count,
                        SUM(CASE WHEN status = 'Not Set' THEN 1 ELSE 0 END) AS not_set_count,
                        SUM(CASE WHEN status = 'Holiday' THEN 1 ELSE 0 END) AS holiday_count
                    FROM 
                        attendance_record
                    WHERE 
                        student_id = ? 
                        AND DATE_FORMAT(date, '%Y-%m') =  DATE_FORMAT(?, '%Y-%m')";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(["success" => false, "message" => "Failed to prepare statement: " . $conn->error]);
            return;
        }

        $stmt->bind_param("ss", $studentId,$date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $attendanceSummary = [
                "present_count" => $row['present_count'],
                "absent_count" => $row['absent_count'],
                "not_set_count" => $row['not_set_count'],
                "holiday_count" => $row['holiday_count']
            ];

            echo json_encode(["success" => true, "message" => "Attendance summary fetched successfully", "data" => $attendanceSummary]);
        } else {
            echo json_encode(["success" => false, "message" => "No attendance record found for the student"]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request method"]);
    }
}
    



function fetchAttendance($conn) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $date = isset($_POST['date']) ? $_POST['date'] : '';

        if (empty($date)) {
            echo json_encode(["error" => "Date parameter is required"]);
            return;
        }

        // Query to fetch all students and their attendance for the specified date (if available)
        $query = "SELECT 
                      s.student_id,
                      s.photo,
                      s.first_name, 
                      s.last_name, 
                      s.roll_no, 
                      s.class_subject, 
                      s.school_college, 
                      s.std, 
                      COALESCE(a.id, 0) AS attendance_id, 
                      ? AS date, 
                      COALESCE(a.status, 'Not Set') AS status
                  FROM 
                      student_record s
                  LEFT JOIN 
                      attendance_record a 
                  ON 
                      s.student_id = a.student_id AND a.date = ?
                  ORDER BY 
                      s.student_id";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
            return;
        }

        $stmt->bind_param("ss", $date, $date); // Bind the date parameter twice
        $stmt->execute();
        $result = $stmt->get_result();

        $attendanceRecords = array();

        while ($row = $result->fetch_assoc()) {
            $attendanceRecords[] = $row;
        }

        // Return the attendance records as JSON
        echo json_encode($attendanceRecords);

        $stmt->close();
        $conn->close();
    }
}


function insertUpdteAttendance($conn) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get POST data
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;
        $date = isset($_POST['date']) ? $_POST['date'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';

          // Validate the date: ensure it's not in the future
            $today = date('Y-m-d');
            if ($attendanceDate > $today) {
                 echo json_encode(["success" => false, "message" => "Future Date is not allowed"]);
                    return ;  
            }

       
        // Validate required fields
        if (empty($date) || empty($status) || $student_id == 0) {
            echo json_encode(["success" => false, "message" => "Missing required fields"]);
            return;
        }

      // Check if an attendance record already exists for the student and date
        $stmt = mysqli_prepare($conn, "SELECT id FROM attendance_record WHERE student_id = ? AND date = ?");
        mysqli_stmt_bind_param($stmt, 'is', $studentId, $attendanceDate);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);


        // Prepare the query based on whether it's an insert or update
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $query = "UPDATE attendance_record SET status = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                echo json_encode(["success" => false, "message" => "Failed to prepare statement: " . $conn->error]);
                return;
            }
            $stmt->bind_param("si", $status, $id); // Removed student_id check
            
        } else {
            
            $query = "INSERT INTO attendance_record (student_id, date, status) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                echo json_encode(["success" => false, "message" => "Failed to prepare statement: " . $conn->error]);
                return;
             }
            $stmt->bind_param("iss", $student_id, $date, $status); // student_id is int
        }

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => ($id == 0) ? "Inserted successfully" : "Updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Handle invalid request method
        echo json_encode(["success" => false, "message" => "Invalid request method"]);
    }
}
?>
