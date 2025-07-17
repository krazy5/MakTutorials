<?php
require '../database/config.php';

if (isset($_GET['student_id']) && isset($_GET['subject'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);
    $subject = mysqli_real_escape_string($conn, $_GET['subject']);

    // Fetch performance data based on the selected subject or all subjects
    $where_clause = $subject === 'ALL' ? "" : " AND subject = '$subject'";
    $performance_query = "SELECT subject, percentage, test_date FROM student_tests WHERE student_id = '$student_id' $where_clause ORDER BY test_date ASC";
    $performance_result = mysqli_query($conn, $performance_query);

    $data = ['dates' => [], 'subjects' => []];
    $subjects = [];
    $all_dates = [];

    while ($row = mysqli_fetch_assoc($performance_result)) {
        $date = $row['test_date'];
        $subject_name = $row['subject'];

        // Store test dates only once
        if (!in_array($date, $all_dates)) {
            $all_dates[] = $date;
        }

        // Group by subject
        if (!isset($subjects[$subject_name])) {
            $subjects[$subject_name] = ['subject_name' => $subject_name, 'percentages' => []];
        }
        $subjects[$subject_name]['percentages'][$date] = $row['percentage'];
    }

    // Sort the dates
    sort($all_dates);
    $data['dates'] = $all_dates;

    // Fill gaps in the data for subjects that didn't have tests on all dates
    foreach ($subjects as $subject_name => $subject_data) {
        $subject_data_filled = [];
        foreach ($all_dates as $date) {
            $subject_data_filled[] = $subject_data['percentages'][$date] ?? null; // Use null for missing values
        }
        $subjects[$subject_name]['percentages'] = $subject_data_filled;
    }

    $data['subjects'] = array_values($subjects); // Convert associative array to indexed array
    echo json_encode($data);
}
?>
