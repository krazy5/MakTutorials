<?php

require '../database/config.php';

// Fetch all students for the student dropdown
$students_query = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS student_name FROM student_record";
$students_result = mysqli_query($conn, $students_query);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Performance Graph</title>

    <!-- Include Chart.js for graph plotting -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #0069d9;
            border-color: #005cbf;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
        <!-- Navigation Bar -->
        <?php include '../navigation_menu/navigation.php' ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h4>Student Performance Graph
					<a href="javascript:void(0);" class="btn btn-danger float-end" onclick="goBack()">Back</a></h4>
					 
                </div>
                <div class="card-body">
                    <form id="performanceForm">
                        <!-- Student Dropdown -->
                        <div class="mb-3">
                            <label for="student" class="form-label">Select Student</label>
                            <select name="student" id="student" class="form-select" required>
                                <option value="">Select Student</option>
                                <?php while ($student = mysqli_fetch_assoc($students_result)) : ?>
                                    <option value="<?= $student['student_id']; ?>"><?= $student['student_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Subject Dropdown (Populated via JS/Ajax after selecting student) -->
                        <div class="mb-3">
                            <label for="subject" class="form-label">Select Subject</label>
                            <select name="subject" id="subject" class="form-select" required>
                                <option value="ALL">All Subjects</option>
                            </select>
                        </div>
                    </form>

                    <!-- Placeholder for Graph -->
                    <div class="mb-3">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load JS libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Initialize empty chart variable
let performanceChart;

// Function to render graph using Chart.js
// Function to render graph using Chart.js
function renderGraph(data) {
    const ctx = document.getElementById('performanceChart').getContext('2d');

    // Destroy the previous chart instance if it exists
    if (performanceChart) {
        performanceChart.destroy();
    }

    // Create new chart
    performanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.dates, // Test dates
            datasets: data.subjects.map((subject, index) => ({
                label: subject.subject_name,
                data: subject.percentages,
                borderColor: `hsl(${index * 60}, 100%, 50%)`, // Dynamic color for each subject
                fill: false,
                spanGaps: true // Ensures gaps between data points are connected by lines
            }))
        },
        options: {
            scales: {
                x: { title: { display: true, text: 'Date' }},
                y: { title: { display: true, text: 'Percentage' }}
            }
        }
    });
}


// Fetch performance data and render graph
function fetchAndRenderGraph(student_id, subject = 'ALL') {
    $.ajax({
        url: 'get_performance_data.php',
        type: 'GET',
        data: { student_id: student_id, subject: subject },
        success: function(response) {
            const data = JSON.parse(response);
            if (data && data.dates.length > 0) {
                renderGraph(data);
            } else {
                alert('No data found for the selected filters.');
            }
        },
        error: function() {
            alert('Error fetching performance data.');
        }
    });
}

$('#student').on('change', function() {
    const student_id = $(this).val();

    if (student_id) {
        // Fetch and populate subjects dropdown
        $.ajax({
            url: 'get_subjects.php',
            type: 'GET',
            data: { student_id: student_id },
            success: function(response) {
                const subjects = JSON.parse(response);
                
                // Reset the subjects dropdown and add "All Subjects" option
                $('#subject').html('<option value="ALL">All Subjects</option>');

                // Populate the subjects dropdown
                subjects.forEach(subject => {
                    $('#subject').append(`<option value="${subject.subject}">${subject.subject}</option>`);
                });

                // Fetch and render graph for "ALL" subjects by default when a student is selected
                fetchAndRenderGraph(student_id, 'ALL');
            },
            error: function() {
                alert('Error fetching subjects.');
            }
        });
    } else {
        $('#subject').html('<option value="ALL">All Subjects</option>'); // Default
        $('#performanceChart').remove(); // Remove the graph if no student is selected
    }
});

// Fetch and render graph when a subject is selected
$('#subject').on('change', function() {
    const student_id = $('#student').val();
    const subject = $(this).val();

    if (student_id && subject) {
        fetchAndRenderGraph(student_id, subject);
    }
});
  function goBack() {
        // Redirect to index.php
        window.open('index.php', '_self');
        // Close the current tab
        window.close();
    }  
</script>

</body>
</html>
