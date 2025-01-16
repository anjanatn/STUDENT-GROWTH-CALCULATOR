<?php
session_start();

// Check if teacher is logged in
if (!isset($_SESSION['teacher'])) {
    header("Location: login_teacher.php");
    exit;
}

// Database connection
$host = 'localhost';
$db = 'mydb';
$user = 'root';
$pass = 'root';
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of students
$student_count = $conn->query("SELECT COUNT(*) AS count FROM student")->fetch_assoc()['count'];

// Fetch teacher details
$teacher_email = $_SESSION['teacher'];
$teacher_details = $conn->query("SELECT * FROM teacher WHERE email='$teacher_email'")->fetch_assoc();

// Fetch student details
$students = $conn->query("SELECT * FROM student");

// If form is submitted to add a student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_student'])) {
    $reg_num = $_POST['reg_num'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $fathers_name = $_POST['fathers_name'];
    $semester = $_POST['semester'];
    $password = $_POST['password']; // Store hashed in production

    $sql = "INSERT INTO student (reg_num, name, email, fathers_name, semester, password) VALUES ('$reg_num', '$name', '$email', '$fathers_name', '$semester', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully!";
        header("Refresh:0");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            padding: 20px;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
            margin-bottom: 20px;
        }
        h3 {
            margin-top: 30px;
            margin-bottom: 10px;
            color: #555;
        }
        p {
            margin-bottom: 15px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        td {
            background-color: #f9f9f9;
        }
        .action-buttons form {
            display: inline;
        }
        .action-buttons button {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .action-buttons button:hover {
            background-color: #0056b3;
        }
        .add-student-form {
            margin-top: 40px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input:focus {
            border-color: #007bff;
            outline: none;
        }
        button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #218838;
        }
        .logout {
            text-align: right;
        }
        .logout a {
            text-decoration: none;
            color: #dc3545;
        }
        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Teacher Dashboard</h1>
        <h2>Welcome, <?php echo htmlspecialchars($teacher_details['name']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($teacher_details['email']); ?></p>
        <p>Subject: <?php echo htmlspecialchars($teacher_details['subject']); ?></p>

        <h3>Total Number of Students: <?php echo $student_count; ?></h3>

        <h3>Students List</h3>
        <table>
            <tr>
                <th>Register Number</th>
                <th>Name</th>
                <th>Email</th>
                <th>Father's Name</th>
                <th>Semester</th>
                <th>Actions</th>
            </tr>
            <?php while($student = $students->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($student['reg_num']); ?></td>
                <td><?php echo htmlspecialchars($student['name']); ?></td>
                <td><?php echo htmlspecialchars($student['email']); ?></td>
                <td><?php echo htmlspecialchars($student['fathers_name']); ?></td>
                <td><?php echo htmlspecialchars($student['semester']); ?></td>
                <td class="action-buttons">
                    <form method="GET" action="edit_student.php">
                        <input type="hidden" name="reg_num" value="<?php echo htmlspecialchars($student['reg_num']); ?>">
                        <button type="submit">Edit</button>
                    </form>
                    <form method="GET" action="activity_points.php">
                        <input type="hidden" name="reg_num" value="<?php echo htmlspecialchars($student['reg_num']); ?>">
                        <button type="submit">Activity Points</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>

        <h3>Add a New Student</h3>
        <form method="POST" action="teacher_dashboard.php" class="add-student-form">
            <label for="reg_num">Register Number:</label>
            <input type="text" id="reg_num" name="reg_num" required>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="fathers_name">Father's Name:</label>
            <input type="text" id="fathers_name" name="fathers_name" required>
            <label for="semester">Semester:</label>
            <input type="text" id="semester" name="semester" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="add_student">Add Student</button>
        </form>

        <div class="logout">
            <p><a href="logout.php">Logout</a></p>
        </div>
    </div>
</body>
</html>
