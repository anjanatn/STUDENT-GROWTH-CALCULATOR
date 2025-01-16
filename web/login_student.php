<?php
session_start(); // Start session to store user info
include('config.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_num = mysqli_real_escape_string($conn, $_POST['reg_num']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // SQL query to check if student exists with provided credentials
    $query = "SELECT * FROM student WHERE reg_num = '$reg_num' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Fetch student data
        $student = mysqli_fetch_assoc($result);

        // Store student details in session variables
        $_SESSION['reg_num'] = $student['reg_num'];
        $_SESSION['name'] = $student['name'];

        // Redirect to the student dashboard
        header("Location: student_dashboard.php");
        exit();
    } else {
        // Incorrect credentials
        $error_message = "Invalid registration number or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f4f7f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: linear-gradient(to bottom right, #e6f0ff, #f4f7f9);
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #1a73e8;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #1a73e8;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0f5bcc;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        a {
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        a button {
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        a button:hover {
            background-color: #e0e0e0;
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Student Login</h1>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="login_student.php">
            <label for="reg_num">Registration Number:</label>
            <input type="text" name="reg_num" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Login">
        </form>
        <a href="index.php"><button type="button">Back to Index</button></a>
    </div>

</body>
</html>
