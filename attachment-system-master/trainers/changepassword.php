<?php
session_start();
include "includes/db.php";
$conn = $db;

// Proper authentication check - redirect if not trainer
if (!isset($_SESSION['utype']) || $_SESSION['utype'] != 'trainer') {
    echo "<script>alert('You must login first'); location.href='trainerlogin.php';</script>";
    exit();
}

if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: trainerlogin.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("location: trainerlogin.php");
    exit();
}

// Change password logic - with security improvements
if (isset($_POST['change_pwd'])) {
    $email = trim($_POST['email']);
    $cpassword = trim($_POST['cpassword']);
    $password = trim($_POST['password']);
    $re_password = trim($_POST['re_password']);

    // Server-side validation
    $errors = array();

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }

    // Validate password strength
    if (empty($password) || strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }

    // Check if passwords match
    if ($password != $re_password) {
        $errors[] = "The two passwords do not match";
    }

    if (empty($errors)) {
        // Use prepared statement to prevent SQL injection
        $cpassword_md5 = md5($cpassword);
        
        $stmt = $conn->prepare("SELECT * FROM trainers WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $cpassword_md5);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->num_rows;
        $stmt->close();

        if ($rows !== 1) {
            echo "<script>alert('Invalid email or current password'); window.location='changepassword.php';</script>";
        } else {
            $password_md5 = md5($password);
            $update_stmt = $conn->prepare("UPDATE trainers SET password = ? WHERE email = ?");
            $update_stmt->bind_param("ss", $password_md5, $email);
            
            if ($update_stmt->execute()) {
                // Log the password change
                $trainer_id = $_SESSION['user']['trainer_id'];
                $date = date('Y-m-d H:i:s');
                $log_stmt = $conn->prepare("INSERT INTO trainerlogs (trainer_id, action, time) VALUES (?, 'Change Password', ?)");
                $log_stmt->bind_param("is", $trainer_id, $date);
                $log_stmt->execute();
                $log_stmt->close();
                
                echo "<script>alert('Password updated successfully'); window.location='trainerlogin.php';</script>";
            } else {
                echo "<script>alert('Failed to update password'); window.location='changepassword.php';</script>";
            }
            $update_stmt->close();
        }
    } else {
        $error_msg = implode("\\n", $errors);
        echo "<script>alert('$error_msg'); window.location='changepassword.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Trainer - Change Password | UITS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(145deg, #f0f4fa 0%, #e6ecf3 100%);
            color: #0f1825;
            line-height: 1.5;
            min-height: 100vh;
        }

        #top-navigation {
            background: linear-gradient(105deg, #0a1c2c 0%, #0f2f44 100%);
            padding: 0.9rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            box-shadow: 0 15px 30px -12px rgba(0,0,0,0.25);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        #logo {
            font-size: 1.9rem;
            font-weight: 800;
            background: linear-gradient(135deg, #FFE5B4, #FFB347, #FF8C42);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #logo i {
            background: rgba(255,255,255,0.12);
            padding: 10px;
            border-radius: 16px;
            font-size: 1.4rem;
            color: #FFB347;
        }

        #student_name {
            background: rgba(255,255,255,0.1);
            padding: 0.6rem 1.8rem;
            border-radius: 60px;
            font-size: 0.95rem;
            color: rgba(255,248,225,0.95);
            font-weight: 500;
            border: 1px solid rgba(255,180,70,0.3);
        }

        #student_name i {
            margin-right: 8px;
            color: #FFB347;
        }

        #student_name span em {
            font-style: normal;
            font-weight: 700;
            color: #FFD966;
        }

        .admincontent {
            display: flex;
            gap: 2rem;
            max-width: 1480px;
            margin: 2rem auto;
            padding: 0 1.8rem;
        }

        .sidebar {
            flex: 0 0 290px;
            background: rgba(255,255,255,0.96);
            border-radius: 36px;
            box-shadow: 0 20px 38px -12px rgba(0,0,0,0.12);
            overflow: hidden;
            height: fit-content;
            position: sticky;
            top: 95px;
            transition: all 0.3s ease;
        }

        .sidebar:hover {
            transform: translateY(-4px);
        }

        #menu_list {
            list-style: none;
            padding: 1.2rem 0.8rem;
        }

        .menu_items_link {
            display: block;
            text-decoration: none;
            color: #1C2F41;
            font-weight: 500;
            transition: all 0.25s ease;
            margin-bottom: 6px;
            border-radius: 50px;
        }

        .menu_items_list {
            padding: 0.9rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 0.95rem;
            border-radius: 50px;
            transition: all 0.25s;
        }

        .menu_items_list i {
            width: 28px;
            font-size: 1.2rem;
            color: #6C86A3;
        }

        .menu_items_link:hover .menu_items_list {
            background: linear-gradient(95deg, #FFF4E6, #FFFFFF);
        }

        .menu_items_link:hover .menu_items_list i {
            color: #F28C28;
        }

        .menu_items_link.active-password .menu_items_list {
            background: linear-gradient(95deg, #FFE4C0, #FFF9F0);
            border-left: 4px solid #F28C28;
            font-weight: 700;
        }
        .menu_items_link.active-password .menu_items_list i {
            color: #F28C28;
        }

        .main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .main h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1.8rem;
            color: #0C2639;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .main h2 i {
            background: linear-gradient(145deg, #F28C28, #FFB347);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 2rem;
        }

        .main h2:after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 4px;
            background: linear-gradient(90deg, #F28C28, #FFD28F);
            border-radius: 8px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.3rem;
            margin-bottom: 2.5rem;
            width: 100%;
            max-width: 800px;
        }

        .stat-card {
            background: white;
            border-radius: 28px;
            padding: 1.2rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 10px 20px -8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            border: 1px solid rgba(242,140,40,0.12);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -12px rgba(0,0,0,0.12);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #FFEFDF, #FFE2C9);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon i {
            font-size: 1.6rem;
            color: #F28C28;
        }

        .stat-info h3 {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6F8FAC;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info p {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0C2639;
            margin-top: 4px;
        }

        .password-card {
            background: white;
            border-radius: 32px;
            padding: 2rem;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08);
            border: 1px solid #ECF2F9;
            transition: all 0.3s ease;
        }

        .password-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 45px -12px rgba(0,0,0,0.15);
        }

        .inputform {
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .inputform label {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #4a627a;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .inputform label i {
            color: #F28C28;
            font-size: 0.85rem;
        }

        .inputform input {
            padding: 14px 18px;
            border: 1px solid #cfdfed;
            border-radius: 20px;
            font-size: 0.95rem;
            font-family: 'Inter', monospace;
            background: #fefefe;
            transition: 0.2s;
            outline: none;
            color: #1e2f3e;
        }

        .inputform input:focus {
            border-color: #F28C28;
            box-shadow: 0 0 0 3px rgba(242,140,40,0.1);
            background: #ffffff;
        }

        .password-hint {
            font-size: 0.7rem;
            color: #8a99b0;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .password-hint i {
            font-size: 0.65rem;
            color: #F28C28;
        }

        .btn {
            background: linear-gradient(125deg, #F28C28, #FF9F4A);
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.25s ease;
            width: 100%;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 12px rgba(242,140,40,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn:hover {
            background: linear-gradient(125deg, #E07A1A, #F28C28);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(242,140,40,0.35);
        }

        .btn:active {
            transform: translateY(1px);
        }

        @media (max-width: 900px) {
            .admincontent {
                flex-direction: column;
                padding: 0 1.2rem;
            }
            .sidebar {
                position: static;
                width: 100%;
            }
            .password-card {
                margin: 0 1rem;
                padding: 1.5rem;
            }
        }

        @media (max-width: 600px) {
            #top-navigation {
                padding: 0.8rem 1.2rem;
            }
            .main h2 {
                font-size: 1.6rem;
            }
            .stats-container {
                grid-template-columns: 1fr;
            }
        }

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #EAF0F6;
            border-radius: 12px;
        }
        ::-webkit-scrollbar-thumb {
            background: #F28C28;
            border-radius: 12px;
        }
    </style>
</head>

<body>
    <div id="top-navigation">
        <div id="logo"><i class="fas fa-chalkboard-user"></i> UITS</div>
        <?php if (isset($_SESSION['user'])) : ?>
            <div id="student_name">
                <i class="fas fa-user-check"></i>
                <span><em>Welcome,</em>&nbsp;</span>
                <span style="font-weight:700;"><?php echo htmlspecialchars($_SESSION['user']['trainername']); ?></span>
            </div>
        <?php endif ?>
    </div>

    <div class="admincontent">
        <div class="sidebar">
            <ul id="menu_list">
                <a class="menu_items_link" href="trainerprofile.php">
                    <li class="menu_items_list"><i class="fas fa-user-circle"></i> My Profile</li>
                </a>
                <a class="menu_items_link" href="assignedtrainer.php">
                    <li class="menu_items_list"><i class="fas fa-user-plus"></i> Add Student</li>
                </a>
                <a class="menu_items_link" href="viewlogbook.php">
                    <li class="menu_items_list"><i class="fas fa-users"></i> Assigned Student</li>
                </a>
                <a class="menu_items_link" href="">
                    <li class="menu_items_list"><i class="fas fa-book-open"></i> Student Logbook</li>
                </a>
                <a class="menu_items_link active-password" href="changepassword.php">
                    <li class="menu_items_list"><i class="fas fa-key"></i> Change Password</li>
                </a>
                <a class="menu_items_link" href="assignedtrainer.php?logout">
                    <li class="menu_items_list"><i class="fas fa-sign-out-alt"></i> Logout</li>
                </a>
            </ul>
        </div>

        <div class="main">
            <h2><i class="fas fa-lock"></i> CHANGE PASSWORD</h2>

            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="stat-info">
                        <h3>Password Policy</h3>
                        <p>Minimum 8 characters</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-sync-alt"></i></div>
                    <div class="stat-info">
                        <h3>Regular Update</h3>
                        <p>Change every 90 days</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-database"></i></div>
                    <div class="stat-info">
                        <h3>Secure Storage</h3>
                        <p>Encrypted in database</p>
                    </div>
                </div>
            </div>

            <div class="password-card">
                <form method="post" id="studentlogin" action="changepassword.php" onSubmit="return validateForm()">
                    <div class="inputform">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email address" required>
                    </div>
                    <div class="inputform">
                        <label><i class="fas fa-shield-alt"></i> Current Password</label>
                        <input type="password" name="cpassword" id="cpassword" placeholder="Enter current password" required>
                    </div>
                    <div class="inputform">
                        <label><i class="fas fa-key"></i> New Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter new password" required>
                        <div class="password-hint">
                            <i class="fas fa-info-circle"></i> Password must be at least 8 characters
                        </div>
                    </div>
                    <div class="inputform">
                        <label><i class="fas fa-redo-alt"></i> Repeat New Password</label>
                        <input type="password" name="re_password" id="re_password" placeholder="Confirm new password" required>
                    </div>
                    <div class="inputform">
                        <button type="submit" class="btn" id="change_pwd" name="change_pwd">
                            <i class="fas fa-save"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Complete validateForm function with all validations
        function validateForm() {
            // Get form field values
            var email = document.getElementById("email").value.trim();
            var cpassword = document.getElementById("cpassword").value;
            var password = document.getElementById("password").value;
            var re_password = document.getElementById("re_password").value;
            
            // Validate email - must not be empty, contain @ and .
            if (email.length == 0) {
                alert("Email address cannot be empty");
                document.getElementById("email").focus();
                return false;
            }
            if (email.indexOf("@") == -1) {
                alert("Please enter a valid email address containing '@'");
                document.getElementById("email").focus();
                return false;
            }
            if (email.indexOf(".") == -1) {
                alert("Please enter a valid email address containing a domain (e.g., .com, .org)");
                document.getElementById("email").focus();
                return false;
            }
            
            // Validate current password - not empty
            if (cpassword == "") {
                alert("Current password cannot be empty");
                document.getElementById("cpassword").focus();
                return false;
            }
            
            // Validate new password - not empty and minimum 8 characters
            if (password == "") {
                alert("New password cannot be empty");
                document.getElementById("password").focus();
                return false;
            }
            if (password.length < 8) {
                alert("Password should have at least 8 characters for security");
                document.getElementById("password").focus();
                return false;
            }
            
            // Check if new password is same as current password (optional security check)
            if (password == cpassword) {
                alert("New password cannot be the same as your current password");
                document.getElementById("password").focus();
                return false;
            }
            
            // Validate repeat password - must match new password
            if (re_password == "") {
                alert("Please confirm your new password");
                document.getElementById("re_password").focus();
                return false;
            }
            if (re_password !== password) {
                alert("The two passwords do not match. Please re-enter your new password.");
                document.getElementById("re_password").focus();
                return false;
            }
            
            // All validations passed
            return true;
        }
    </script>
</body>
</html>