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

// Get the student registration number from the URL
if (isset($_GET['reg_num'])) {
    $reg_num = $_GET['reg_num'];

    // Fetch student details
    $student = $conn->query("SELECT * FROM student WHERE reg_num='$reg_num'")->fetch_assoc();

    // Fetch existing marks
    $sem_one = $conn->query("SELECT * FROM sem_one WHERE reg_no='$reg_num'")->fetch_assoc();
    $sem_two = $conn->query("SELECT * FROM sem_two WHERE reg_no='$reg_num'")->fetch_assoc();

    if (!$student) {
        echo "Student not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

// If form is submitted to update student details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_student'])) {
    $name = $_POST['edit_name'];
    $email = $_POST['edit_email'];
    $fathers_name = $_POST['edit_fathers_name'];
    $semester = $_POST['edit_semester'];

    $sql = "UPDATE student SET name='$name', email='$email', fathers_name='$fathers_name', semester='$semester' WHERE reg_num='$reg_num'";
    if ($conn->query($sql) === TRUE) {
        echo "Student details updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// If form is submitted to add marks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_marks'])) {
    // Capture marks
    $chemistry = $_POST['chemistry'];
    $physics = $_POST['physics'];
    $maths = $_POST['maths'];
    $electronics = $_POST['electronics'];
    $electrical = $_POST['electrical'];
    $civil_mech = $_POST['civil_mech'];

    // Insert or update sem_one
    $sql_one = "REPLACE INTO sem_one (reg_no, name, chemistry, physics, maths) VALUES ('$reg_num', '{$student['name']}', '$chemistry', '$physics', '$maths')";

    // Insert or update sem_two
    $sql_two = "REPLACE INTO sem_two (reg_no, name, electronics, electrical, civil_mech) VALUES ('$reg_num', '{$student['name']}', '$electronics', '$electrical', '$civil_mech')";

    if ($conn->query($sql_one) === TRUE && $conn->query($sql_two) === TRUE) {
        echo "Marks added/updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>
    <form method="POST" action="edit_student.php?reg_num=<?php echo htmlspecialchars($reg_num); ?>">
        <input type="hidden" name="reg_num" value="<?php echo htmlspecialchars($reg_num); ?>">
        <label for="edit_name">Name:</label>
        <input type="text" id="edit_name" name="edit_name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br>
        <label for="edit_email">Email:</label>
        <input type="email" id="edit_email" name="edit_email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br>
        <label for="edit_fathers_name">Father's Name:</label>
        <input type="text" id="edit_fathers_name" name="edit_fathers_name" value="<?php echo htmlspecialchars($student['fathers_name']); ?>" required><br>
        <label for="edit_semester">Semester:</label>
        <input type="text" id="edit_semester" name="edit_semester" value="<?php echo htmlspecialchars($student['semester']); ?>" required><br>
        <button type="submit" name="update_student">Update Student</button>
    </form>

    <h2>Existing Marks</h2>
    <h3>Semester One</h3>
    <p>Chemistry: <?php echo htmlspecialchars($sem_one['chemistry'] ?? 'N/A'); ?></p>
    <p>Physics: <?php echo htmlspecialchars($sem_one['physics'] ?? 'N/A'); ?></p>
    <p>Maths: <?php echo htmlspecialchars($sem_one['maths'] ?? 'N/A'); ?></p>

    <h3>Semester Two</h3>
    <p>Electronics: <?php echo htmlspecialchars($sem_two['electronics'] ?? 'N/A'); ?></p>
    <p>Electrical: <?php echo htmlspecialchars($sem_two['electrical'] ?? 'N/A'); ?></p>
    <p>Civil/Mechanical: <?php echo htmlspecialchars($sem_two['civil_mech'] ?? 'N/A'); ?></p>

    <h2>Add/Update Marks</h2>
    <form method="POST" action="edit_student.php?reg_num=<?php echo htmlspecialchars($reg_num); ?>">
        <input type="hidden" name="reg_num" value="<?php echo htmlspecialchars($reg_num); ?>">
        <h3>Semester One</h3>
        <label for="chemistry">Chemistry:</label>
        <input type="number" id="chemistry" name="chemistry" required><br>
        <label for="physics">Physics:</label>
        <input type="number" id="physics" name="physics" required><br>
        <label for="maths">Maths:</label>
        <input type="number" id="maths" name="maths" required><br>

        <h3>Semester Two</h3>
        <label for="electronics">Electronics:</label>
        <input type="number" id="electronics" name="electronics" required><br>
        <label for="electrical">Electrical:</label>
        <input type="number" id="electrical" name="electrical" required><br>
        <label for="civil_mech">Civil/Mechanical:</label>
        <input type="number" id="civil_mech" name="civil_mech" required><br>

        <button type="submit" name="add_marks">Add/Update Marks</button>
    </form>

    <p><a href="teacher_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
