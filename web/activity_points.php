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
$user = 'root'; // Change this if you have a different username
$pass = 'root'; // Change this if you have a different password
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student details by reg_no
if (isset($_GET['reg_num'])) {
    $reg_no = $_GET['reg_num'];

    // Fetch student details
    $student_result = $conn->query("SELECT * FROM student WHERE reg_num = '$reg_no'");
    $student = $student_result->fetch_assoc();
    $student_name = $student['name'];

    // Fetch existing activity points for the student
    $activity_points_result = $conn->query("SELECT * FROM activity_points WHERE reg_no = '$reg_no'");
} else {
    echo "Student not found!";
    exit;
}

// Add new activity point
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_activity_point'])) {
    $date = $_POST['date'];
    $certificate_name = $_POST['certificate_name'];
    $points = $_POST['points'];

    $sql = "INSERT INTO activity_points (reg_no, name_student, matter, point, date) 
            VALUES ('$reg_no', '$student_name', '$certificate_name', '$points', '$date')";

    if ($conn->query($sql) === TRUE) {
        header("Refresh:0"); // Refresh page to show new data
        echo "New activity point added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update existing activity point
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_activity_point'])) {
    $activity_id = $_POST['activity_id'];
    $date = $_POST['date'];
    $certificate_name = $_POST['certificate_name'];
    $points = $_POST['points'];

    $sql = "UPDATE activity_points 
            SET matter = '$certificate_name', point = '$points', date = '$date' 
            WHERE reg_no = '$reg_no' AND id = '$activity_id'";

    if ($conn->query($sql) === TRUE) {
        header("Refresh:0"); // Refresh page to show updated data
        echo "Activity point updated successfully!";
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
    <title>Activity Points for <?php echo htmlspecialchars($student_name); ?></title>
</head>
<body>
    <h1>Activity Points for <?php echo htmlspecialchars($student_name); ?></h1>

    <h3>Existing Activity Points</h3>
    <table border="1">
        <tr>
            <th>Date</th>
            <th>Certificate Name</th>
            <th>Points</th>
            <th>Actions</th>
        </tr>
        <?php while($activity = $activity_points_result->fetch_assoc()) { ?>
        <tr>
            <form method="POST" action="activity_points.php?reg_num=<?php echo $reg_no; ?>">
                <td>
                    <input type="date" name="date" value="<?php echo htmlspecialchars($activity['date']); ?>" required>
                </td>
                <td>
                    <input type="text" name="certificate_name" value="<?php echo htmlspecialchars($activity['matter']); ?>" required>
                </td>
                <td>
                    <input type="text" name="points" value="<?php echo htmlspecialchars($activity['point']); ?>" required>
                </td>
                <td>
                    <input type="hidden" name="activity_id" value="<?php echo htmlspecialchars($activity['id']); ?>">
                    <button type="submit" name="update_activity_point">Update</button>
                </td>
            </form>
        </tr>
        <?php } ?>
    </table>

    <h3>Add New Activity Point</h3>
    <form method="POST" action="activity_points.php?reg_num=<?php echo $reg_no; ?>">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br>

        <label for="certificate_name">Certificate Name:</label>
        <input type="text" id="certificate_name" name="certificate_name" required><br>

        <label for="points">Points:</label>
        <input type="text" id="points" name="points" required><br>

        <button type="submit" name="add_activity_point">Add Activity Point</button>
    </form>

    <p><a href="teacher_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
