<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C++ Learning Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background-color: #f8f9fa;
            padding: 50px 0;
            text-align: center;
        }
        .card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body>
 <?php include 'navigation_menu.php'   ?>
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <h1>Welcome to the C++ Learning Portal</h1>
            <p class="lead">Your one-stop solution to mastering C++ programming with tutorials and assignments.</p>
        </div>
    </section>

    <!-- Tutorials Section -->
    <section id="tutorials" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">C++ Tutorials</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Introduction to C++</h5>
                            <p class="card-text">Learn about the history, features, and why C++ is widely used.</p>
                            <a href="https://learnwithcpp.blogspot.com/p/01basic.html" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Lab Assignments</h5>
                            <p class="card-text">Solve the assignment to make your concept strong</p>
                            <a href="https://learnwithcpp.blogspot.com/p/lab-assignments.html" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Advanced Topics</h5>
                            <p class="card-text">Dive deeper into templates, STL, and advanced memory management.</p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Assignments Section -->
    <section id="assignments" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">C++ Assignments</h2>
            <p class="text-center">Practice makes perfect! Tackle these assignments to test your skills:</p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Write a program to calculate the factorial of a number.</li>
                <li class="list-group-item">Implement a class to manage a library's book inventory.</li>
                <li class="list-group-item">Create a program to solve the N-Queens problem using backtracking.</li>
            </ul>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; 2024 C++ Learning Portal. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
