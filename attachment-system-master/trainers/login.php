<?php
session_start();

// connect to database
$db = mysqli_connect("localhost", "root", "", "dbsupervise");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Only run login if form was submitted
if (isset($_POST['login_btn'])) {
    login();
}

function login() {
    global $db;
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM trainers WHERE email = ?";
    $stmt = mysqli_prepare($db, $query);
    
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($db));
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
            // Upgrade hash to secure password_hash for the future
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $update_q = "UPDATE trainers SET password=? WHERE trainer_id=?";
            $update_stmt = mysqli_prepare($db, $update_q);
            mysqli_stmt_bind_param($update_stmt, "si", $new_hash, $logged_in_user['trainer_id']);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);
        }
    }
    
    if ($valid_password) {
        
        $_SESSION['user'] = $logged_in_user;
        $_SESSION['success'] = "You are now logged in";
        $_SESSION['utype'] = "trainer";
        
        // Insert into trainer logs - Check if table exists first
        $trainer_id = $logged_in_user['trainer_id'];
        $date = date('Y-m-d H:i:s');
        $ip_address = $_SERVER['REMOTE_ADDR'];
        
        // Check if trainerlogs table exists
        $table_check = mysqli_query($db, "SHOW TABLES LIKE 'trainerlogs'");
        if (mysqli_num_rows($table_check) > 0) {
            $stmt2 = mysqli_prepare($db, "INSERT INTO trainerlogs(trainer_id, action, time, ip_address) VALUES(?, 'Login', ?, ?)");
            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "iss", $trainer_id, $date, $ip_address);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_close($stmt2);
            }
        }
        
        header('location: assignedtrainer.php');
        exit();
        
    } else {
        echo "<script> alert('Wrong email/password combination'); window.location.href='trainerlogin.php'; </script>";
    }
}
?>