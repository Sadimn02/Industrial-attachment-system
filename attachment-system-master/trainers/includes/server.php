<?php
session_start();

// connect to database
$db = mysqli_connect("localhost", "root", "", "dbsupervise");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Redirect if accessed directly without POST data and not logged in
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_COOKIE['remember_token']) && basename($_SERVER['PHP_SELF']) == 'server.php') {
    header("Location: ../trainerlogin.php");
    exit();
}

if (isset($_POST['login_btn'])) {
    login();
}

if (isset($_POST['register_btn'])) {
    register();
}

function register() {
    global $db;
    
    $trainername = mysqli_real_escape_string($db, $_POST['trainername']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $mobile = mysqli_real_escape_string($db, $_POST['mobile']);
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    
    // check if user exists
    $query = "SELECT * FROM trainers WHERE email=? LIMIT 1";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    if ($user) {
        echo "<script>alert('Email already exists');window.location='../trainerregistration.php'</script>";
    } elseif ($password_1 !== $password_2) {
        echo "<script>alert('The two passwords do not match!');window.location='../trainerregistration.php'</script>";
    } else {
        $password = password_hash($password_1, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO trainers (trainername, email, mobile, title, password, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $insert_stmt = mysqli_prepare($db, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, "sssss", $trainername, $email, $mobile, $title, $password);
        $res = mysqli_stmt_execute($insert_stmt);
        mysqli_stmt_close($insert_stmt);
        
        if ($res) {
            echo "<script>alert('Registration successful');window.location='../trainerlogin.php'</script>";
        } else {
            echo "<script>alert('Registration failed');window.location='../trainerregistration.php'</script>";
        }
    }
}

function login() {
    global $db;
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']) ? true : false;
    
    // Use prepared statement to check user
    $query = "SELECT * FROM trainers WHERE email = ?";
    $stmt = mysqli_prepare($db, $query);
    
    if (!$stmt) {
        die("Prepare failed for SELECT: " . mysqli_error($db));
    }
    
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $logged_in_user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    $valid_password = false;
    if ($logged_in_user) {
        $db_pass = $logged_in_user['password'];
        if (password_verify($password, $db_pass)) {
            $valid_password = true;
        } elseif (md5($password) === $db_pass) {
            $valid_password = true;
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $update_q = "UPDATE trainers SET password=? WHERE trainer_id=?";
            $update_stmt = mysqli_prepare($db, $update_q);
            if ($update_stmt) {
                mysqli_stmt_bind_param($update_stmt, "si", $new_hash, $logged_in_user['trainer_id']);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
            }
        }
    }
    
    if ($valid_password) {
        
        $_SESSION['user'] = $logged_in_user;
        $_SESSION['success'] = "You are now logged in";
        $_SESSION['utype'] = "trainer";
        $_SESSION['login_time'] = time();
        
        if ($remember_me) {
            $token = bin2hex(random_bytes(32));
            setcookie('remember_token', $token, time() + (86400 * 7), "/");
            
            $update_query = "UPDATE trainers SET remember_token = ? WHERE trainer_id = ?";
            $update_stmt = mysqli_prepare($db, $update_query);
            if ($update_stmt) {
                mysqli_stmt_bind_param($update_stmt, "si", $token, $logged_in_user['trainer_id']);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
            }
        }
        
        // Insert into trainerlogs - FIXED with error checking
        $trainer_id = $logged_in_user['trainer_id'];
        $date = date('Y-m-d H:i:s');
        $ip_address = $_SERVER['REMOTE_ADDR'];
        
        // Check if trainerlogs table exists first
        $table_check = mysqli_query($db, "SHOW TABLES LIKE 'trainerlogs'");
        if (mysqli_num_rows($table_check) > 0) {
            $stmt2 = mysqli_prepare($db, "INSERT INTO trainerlogs(trainer_id, action, time, ip_address) VALUES(?, 'Login', ?, ?)");
            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "iss", $trainer_id, $date, $ip_address);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_close($stmt2);
            }
        }
        
        // Update last login time
        $update_login = "UPDATE trainers SET last_login = ? WHERE trainer_id = ?";
        $update_stmt = mysqli_prepare($db, $update_login);
        if ($update_stmt) {
            mysqli_stmt_bind_param($update_stmt, "si", $date, $trainer_id);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);
        }
        
        header('location: assignedtrainer.php');
        exit();
        
    } else {
        // Check if login_attempts table exists
        $table_check = mysqli_query($db, "SHOW TABLES LIKE 'login_attempts'");
        if (mysqli_num_rows($table_check) > 0) {
            $fail_stmt = mysqli_prepare($db, "INSERT INTO login_attempts (email, attempt_time, ip_address) VALUES (?, NOW(), ?)");
            if ($fail_stmt) {
                mysqli_stmt_bind_param($fail_stmt, "ss", $email, $_SERVER['REMOTE_ADDR']);
                mysqli_stmt_execute($fail_stmt);
                mysqli_stmt_close($fail_stmt);
            }
        }
        
        echo "<script> alert('Wrong email/password combination'); window.location.href='trainerlogin.php'; </script>";
    }
}

// Auto-login with remember me token
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $query = "SELECT * FROM trainers WHERE remember_token = ?";
    $stmt = mysqli_prepare($db, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        if ($user) {
            $_SESSION['user'] = $user;
            $_SESSION['utype'] = "trainer";
            header('location: assignedtrainer.php');
            exit();
        }
    }
}
?>