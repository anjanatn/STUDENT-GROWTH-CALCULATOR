<?php
session_start(); // Resume session
include('config.php');

// Ensure student is logged in
if (!isset($_SESSION['reg_num'])) {
    header("Location: login_student.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve the student's registration number
$reg_num = $_SESSION['reg_num'];

// Fetch student's marks from both semesters
$query_sem1 = "SELECT * FROM sem_one WHERE reg_no = '$reg_num'";
$query_sem2 = "SELECT * FROM sem_two WHERE reg_no = '$reg_num'";
$result_sem1 = mysqli_query($conn, $query_sem1);
$result_sem2 = mysqli_query($conn, $query_sem2);

$sem1_marks = mysqli_fetch_assoc($result_sem1);
$sem2_marks = mysqli_fetch_assoc($result_sem2);

// Fetch student's other details
$query_student = "SELECT * FROM student WHERE reg_num = '$reg_num'";
$result_student = mysqli_query($conn, $query_student);
$student = mysqli_fetch_assoc($result_student);

// Fetch student's activity points
$query_activity_points = "SELECT * FROM activity_points WHERE reg_no = '$reg_num'";
$result_activity_points = mysqli_query($conn, $query_activity_points);

// Determine pass/fail status
$pass_fail_sem1 = [
    'Chemistry' => $sem1_marks['chemistry'] >= 35 ? 'Pass' : 'Fail',
    'Physics' => $sem1_marks['physics'] >= 35 ? 'Pass' : 'Fail',
    'Maths' => $sem1_marks['maths'] >= 35 ? 'Pass' : 'Fail'
];

$pass_fail_sem2 = [
    'Electronics' => $sem2_marks['electronics'] >= 35 ? 'Pass' : 'Fail',
    'Electrical' => $sem2_marks['electrical'] >= 35 ? 'Pass' : 'Fail',
    'Civil/Mech' => $sem2_marks['civil_mech'] >= 35 ? 'Pass' : 'Fail'
];

// Prepare data for the graph
$labels = ['Chemistry', 'Physics', 'Maths', 'Electronics', 'Electrical', 'Civil/Mech'];
$marks = [
    $sem1_marks['chemistry'],
    $sem1_marks['physics'],
    $sem1_marks['maths'],
    $sem2_marks['electronics'],
    $sem2_marks['electrical'],
    $sem2_marks['civil_mech']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f4f7f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        header {
            background-color: #1a73e8;
            color: white;
            padding: 15px 0;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            margin: 0;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        h2 {
            color: #1a73e8;
        }

        p, table {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        #growthChart {
            width: 100%;
            height: 400px;
            margin-top: 20px;
        }

        footer {
            margin-top: 20px;
            text-align: center;
        }

        a {
            color: #1a73e8;
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 0;
            }

            h1, h2 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
    </header>

    <div class="container">
        <!-- Display student details -->
        <div class="card">
            <h2>Student Details</h2>
            <p><strong>Registration Number:</strong> <?php echo $student['reg_num']; ?></p>
            <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
            <p><strong>Father's Name:</strong> <?php echo $student['fathers_name']; ?></p>
            <p><strong>Semester:</strong> <?php echo $student['semester']; ?></p>
        </div>

        <!-- Display marks -->
        <div class="card">
            <h2>Marks</h2>
            <h3>Semester 1</h3>
            <p>Chemistry: <?php echo $sem1_marks['chemistry']; ?> - <strong><?php echo $pass_fail_sem1['Chemistry']; ?></strong></p>
            <p>Physics: <?php echo $sem1_marks['physics']; ?> - <strong><?php echo $pass_fail_sem1['Physics']; ?></strong></p>
            <p>Maths: <?php echo $sem1_marks['maths']; ?> - <strong><?php echo $pass_fail_sem1['Maths']; ?></strong></p>

            <h3>Semester 2</h3>
            <p>Electronics: <?php echo $sem2_marks['electronics']; ?> - <strong><?php echo $pass_fail_sem2['Electronics']; ?></strong></p>
            <p>Electrical: <?php echo $sem2_marks['electrical']; ?> - <strong><?php echo $pass_fail_sem2['Electrical']; ?></strong></p>
            <p>Civil/Mech: <?php echo $sem2_marks['civil_mech']; ?> - <strong><?php echo $pass_fail_sem2['Civil/Mech']; ?></strong></p>
        </div>

        <!-- Display Activity Points -->
        <div class="card">
            <h2>Activity Points</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Event</th>
                    <th>Points</th>
                </tr>
                <?php while ($activity = mysqli_fetch_assoc($result_activity_points)) { ?>
                    <tr>
                        <td><?php echo $activity['date']; ?></td>
                        <td><?php echo $activity['matter']; ?></td>
                        <td><?php echo $activity['point']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Student Growth Graph -->
        <div class="card">
            <h2>Student Growth</h2>
            <canvas id="growthChart"></canvas>
        </div>
    </div>

    <footer>
        <a href="logout1.php">Logout</a>
    </footer>

    <script>
        const ctx = document.getElementById('growthChart').getContext('2d');
        const growthChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Marks',
                    data: <?php echo json_encode($marks); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100 // Adjust based on the expected maximum marks
                    }
                }
            }
        });
    </script>
</body>
</html>
