<?php
// Start session
session_start();

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password are correct
    if ($username == "admin" && $password == "admin123") {
        // Set session for admin
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #007bff;
            font-weight: 600;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }
        label {
            font-size: 1em;
            color: #555;
            text-align: left;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            outline: none;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #007bff;
        }
        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .button {
            display: inline-block;
            text-decoration: none;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #495057;
        }
        .error-message {
            color: #e74c3c;
            font-size: 0.9em;
            margin-top: 10px;
        }
        @media (max-width: 768px) {
            .container {
                padding: 30px;
            }
            h2 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form method="post" action="login.php">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <!-- Display error message if login fails -->
        <?php if(isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>

        <a class="button" href="index.php">Back to Home</a>
    </div>
</body>
</html>
