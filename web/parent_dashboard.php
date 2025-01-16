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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS -->
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px; /* Max width for larger screens */
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #1a73e8;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
            margin-top: 30px;
            border-bottom: 2px solid #1a73e8;
            padding-bottom: 5px;
        }

        p {
            font-size: 16px;
            margin: 8px 0;
        }

        .marks {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 5px solid #1a73e8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #1a73e8;
            color: white;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #1a73e8;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            body {
                padding: 10px; /* Less padding on small screens */
            }

            .container {
                padding: 15px; /* Less padding on small screens */
            }

            h1 {
                font-size: 24px; /* Smaller font size for header */
            }

            p {
                font-size: 14px; /* Smaller font size for paragraphs */
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome, Sir</h1>
        <h2>Student Name: <?php echo $_SESSION['name']; ?>!</h2>
        
        <!-- Display student details -->
        <h2>Student Details</h2>
        <p><strong>Registration Number:</strong> <?php echo $student['reg_num']; ?></p>
        <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
        <p><strong>Father's Name:</strong> <?php echo $student['fathers_name']; ?></p>
        <p><strong>Semester:</strong> <?php echo $student['semester']; ?></p>
        
        <!-- Display marks -->
        <h2>Marks</h2>
        <div class="marks">
            <h3>Semester 1</h3>
            <p>Chemistry: <?php echo $sem1_marks['chemistry']; ?></p>
            <p>Physics: <?php echo $sem1_marks['physics']; ?></p>
            <p>Maths: <?php echo $sem1_marks['maths']; ?></p>

            <h3>Semester 2</h3>
            <p>Electronics: <?php echo $sem2_marks['electronics']; ?></p>
            <p>Electrical: <?php echo $sem2_marks['electrical']; ?></p>
            <p>Civil/Mech: <?php echo $sem2_marks['civil_mech']; ?></p>
        </div>
        
        <!-- Display Activity Points -->
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

        <a href="logout1.php">Logout</a>
    </div>

</body>
</html>
