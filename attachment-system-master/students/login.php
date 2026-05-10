<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'dbsupervise');

if (isset($_POST['login_btn'])) {
    login();
}

function login() {
    global $db;
    $admissionnumber = mysqli_real_escape_string($db, $_POST['admissionnumber']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $admissionnumber = htmlspecialchars($admissionnumber);
    $password = htmlspecialchars($password);
    $password = md5($password);

    $query = "SELECT * FROM students WHERE admission_number='$admissionnumber' AND password='$password' LIMIT 1";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) {
        $logged_in_user = mysqli_fetch_assoc($results);
        $_SESSION['user'] = $logged_in_user;
        $_SESSION['utype'] = "student";

        $student_id = $_SESSION['user']['student_id'];
        $date = date('Y-m-d H:i:s');
        $stmt3 = "INSERT INTO studentlogs(student_id,action,time) VALUES('$student_id','Login','$date')";
        mysqli_query($db, $stmt3);

        header('location: logbook.php');
    } else {
        echo "<script> alert('Wrong id/password combination'); window.location.href='studentlogin.php'; </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | UITS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #003366;
            --accent: #FFC600;
            --bg: #f0f2f5;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background: linear-gradient(135deg, #003366 0%, #001a33 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .login-container h2 {
            color: #fff;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .login-container p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
        }

        input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #fff;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.1);
        }

        input::placeholder { color: rgba(255, 255, 255, 0.4); }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: var(--accent);
            border: none;
            border-radius: 10px;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 198, 0, 0.3);
        }

        .footer-links {
            margin-top: 25px;
            font-size: 0.8rem;
        }

        .footer-links a {
            color: var(--accent);
            text-decoration: none;
        }

        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <a href="../index.php" class="back-home"><i class="fa fa-arrow-left"></i> Back to Home</a>

    <div class="login-container">
        <div style="margin-bottom: 20px;">
            <i class="fa fa-user-graduate" style="font-size: 3rem; color: var(--accent);"></i>
        </div>
        <h2>Student Portal</h2>
        <p>Please enter your credentials to continue</p>

        <form action="studentlogin.php" method="POST">
            <div class="form-group">
                <i class="fa fa-id-card"></i>
                <input type="text" name="admissionnumber" placeholder="Admission Number" required>
            </div>
            <div class="form-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login_btn" class="btn-login">LOGIN</button>
        </form>

        <div class="footer-links">
            <a href="#">Forgot Password?</a>
        </div>
    </div>

</body>
</html>