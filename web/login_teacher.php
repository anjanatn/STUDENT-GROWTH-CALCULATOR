<?php
session_start();

// Database connection
$host = 'localhost';
$db = 'mydb';
$user = 'root';
$pass = 'root';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // Query the database for teacher login
    $sql = "SELECT * FROM teacher WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Successful login
        $_SESSION['teacher'] = $email;
        header("Location: teacher_dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 1em;
            text-align: left;
            color: #555;
        }
        input {
            padding: 12px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            outline: none;
        }
        input:focus {
            border-color: #007bff;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        .forgot-password {
            text-align: right;
        }
        .forgot-password a {
            text-decoration: none;
            color: #007bff;
            font-size: 0.9em;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Teacher Login</h1>
        <?php if (isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>
        <form method="POST" action="login_teacher.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <div class="forgot-password">
            <a href="#">Forgot Password?</a>
        </div>
    </div>
</body>
</html>
