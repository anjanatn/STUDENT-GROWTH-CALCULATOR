<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1, h2 {
            margin: 0;
            padding-bottom: 20px;
        }
        h1 {
            font-size: 2.5em;
            color: #007bff;
        }
        h2 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 40px;
        }
        .button-group a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border-radius: 6px;
            margin: 10px 0;
            display: block;
            font-size: 1em;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .button-group a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .admin-login a {
            color: #555;
            font-size: 0.9em;
            text-decoration: none;
        }
        .admin-login a:hover {
            text-decoration: underline;
        }
        footer {
            font-size: 0.85em;
            color: #777;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: #f5f8fa;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Growth Calculator</h1>
        <h2>Login As</h2>
        <div class="button-group">
            <a href="login_student.php">Student</a>
            <a href="login_parent.php">Parent</a>
            <a href="login_teacher.php">Teacher</a>
        </div>
        <div class="admin-login">
            <a href="login.php">Admin Login</a>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Student Growth Analysis System. All rights reserved.</p>
    </footer>
</body>
</html>
