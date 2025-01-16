<?php
// Start session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
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

// Fetch number of teachers and students
$teacher_count = $conn->query("SELECT COUNT(*) AS count FROM teacher")->fetch_assoc()['count'];
$student_count = $conn->query("SELECT COUNT(*) AS count FROM student")->fetch_assoc()['count'];

// Fetch teacher and student details
$teachers = $conn->query("SELECT * FROM teacher");
$students = $conn->query("SELECT * FROM student");

// Check if edit_teacher_id is set to edit teacher
if (isset($_GET['edit_teacher_id'])) {
    $edit_teacher_id = $_GET['edit_teacher_id'];

    // Fetch the teacher's details
    $teacher_to_edit = $conn->query("SELECT * FROM teacher WHERE teacher_id = $edit_teacher_id")->fetch_assoc();
}

// If form is submitted to add a new teacher
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update_teacher'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $password = $_POST['password'];

    $sql = "INSERT INTO teacher (name, email, subject, password) VALUES ('$name', '$email', '$subject', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "New teacher added successfully!";
        header("Refresh:0"); // Refresh page after adding teacher
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// If form is submitted to update a teacher
if (isset($_POST['update_teacher'])) {
    $teacher_id = $_POST['teacher_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $password = $_POST['password'];

    $sql = "UPDATE teacher SET name='$name', email='$email', subject='$subject', password='$password' WHERE teacher_id=$teacher_id";
    if ($conn->query($sql) === TRUE) {
        echo "Teacher updated successfully!";
        header("Location: admin_dashboard.php"); // Redirect after update
    } else {
        echo "Error updating teacher: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .statistics {
            margin: 20px 0;
            text-align: center;
            font-size: 1.2em;
            color: #555;
        }
        .table-container {
            margin-top: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        table th, table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .form-container label {
            font-size: 1em;
            color: #555;
        }
        .form-container input {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }
        .form-container input:focus {
            border-color: #007bff;
        }
        .form-container button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            text-decoration: none;
            color: #e74c3c;
            font-size: 1.1em;
            transition: color 0.3s ease;
        }
        .logout a:hover {
            color: #c0392b;
        }
        @media (max-width: 768px) {
            table th, table td {
                padding: 10px;
            }
            .form-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Welcome, Admin</h2>

    <div class="statistics">
        <p>Number of Teachers: <?php echo $teacher_count; ?></p>
        <p>Number of Students: <?php echo $student_count; ?></p>
    </div>

    <div class="table-container">
        <h3>Teachers List</h3>
        <table>
            <tr>
                <th>Teacher ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Action</th>
            </tr>
            <?php while($teacher = $teachers->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $teacher['teacher_id']; ?></td>
                <td><?php echo $teacher['name']; ?></td>
                <td><?php echo $teacher['email']; ?></td>
                <td><?php echo $teacher['subject']; ?></td>
                <td><a href="admin_dashboard.php?edit_teacher_id=<?php echo $teacher['teacher_id']; ?>">Edit</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div class="table-container">
        <h3>Students List</h3>
        <table>
            <tr>
                <th>Register Number</th>
                <th>Name</th>
                <th>Email</th>
                <th>Father's Name</th>
                <th>Semester</th>
            </tr>
            <?php while($student = $students->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $student['reg_num']; ?></td>
                <td><?php echo $student['name']; ?></td>
                <td><?php echo $student['email']; ?></td>
                <td><?php echo $student['fathers_name']; ?></td>
                <td><?php echo $student['semester']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <!-- Edit Teacher Form -->
    <?php if (isset($teacher_to_edit)) { ?>
    <div class="form-container">
        <h3>Edit Teacher</h3>
        <form method="post" action="admin_dashboard.php">
            <input type="hidden" name="teacher_id" value="<?php echo $teacher_to_edit['teacher_id']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $teacher_to_edit['name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $teacher_to_edit['email']; ?>" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" value="<?php echo $teacher_to_edit['subject']; ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="update_teacher">Update Teacher</button>
        </form>
    </div>
    <?php } ?>

    <div class="form-container">
        <h3>Add a New Teacher</h3>
        <form method="post" action="admin_dashboard.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Add Teacher</button>
        </form>
    </div>

    <div class="logout">
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
