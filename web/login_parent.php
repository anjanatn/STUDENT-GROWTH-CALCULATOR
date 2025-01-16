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

        // Redirect to the parent dashboard
        header("Location: parent_dashboard.php");
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
    <title>Parent Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Include external CSS -->
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height of the viewport */
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 300px; /* Set a fixed width for the form */
            text-align: center;
        }

        h1 {
            color: #1a73e8;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #1a73e8;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #155ab6; /* Darker shade on hover */
        }

        .error-message {
            color: red;
            margin-top: 10px;
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

        @media (max-width: 400px) {
            .login-container {
                width: 90%; /* Make the form responsive */
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>Parent Login</h1>

        <?php if (isset($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="login_parent.php">
            <label for="reg_num">Registration Number:</label>
            <input type="text" name="reg_num" id="reg_num" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Login">
        </form>

        <!-- Button to go back to index page -->
        <a href="index.php">Back to Index</a>
    </div>

</body>
</html>
