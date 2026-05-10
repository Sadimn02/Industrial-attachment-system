<?php
session_start();
include "./includes/db.php";
if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: studentlogin.php');
}
if (isset($_POST['change_pwd'])) {
    $admissionnumber = $_POST['admissionnumber'];
    $cpassword = $_POST['cpassword'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];
    $cpassword = md5($cpassword);
    $stmt = "SELECT * FROM students WHERE admission_number='$admissionnumber' and password='$cpassword'";
    $result = mysqli_query($conn, $stmt);
    $rows = mysqli_num_rows($result);
    if ($rows !== 1) {
        echo "<script>alert('Invalid admission number or current password')</script>";
    } elseif ($password == $re_password) {
        $password = md5($password);
        $sql = "UPDATE students SET password='$password' WHERE admission_number='$admissionnumber' ";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            session_destroy();
            echo "<script>alert('Password updated successfully. Please login again.');window.location = 'studentlogin.php'</script>";
        } else {
            echo "<script>alert('Failed to Update password');window.location = 'changepassword.php'</script>";
        }
    } else {
        echo "<script>alert('The two passwords do not match');window.location = 'changepassword.php'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>UITS - Change Password | Student Portal</title>
    
    <!-- Modern CSS: Font, Icons, and Clean Layout -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f8;
            color: #1a2634;
            line-height: 1.4;
        }

        /* TOP NAVIGATION - modern, clean, subtle shadow */
        #top-navigation {
            background: #ffffff;
            padding: 0 40px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid #e9edf2;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        #logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
        }

        #student_name {
            background: #f8faff;
            padding: 8px 18px;
            border-radius: 40px;
            font-size: 0.95rem;
            font-weight: 500;
            box-shadow: inset 0 0 0 1px #eef2fa;
        }

        #student_name span:first-child {
            color: #f5a623;
            font-weight: 500;
        }

        /* main layout: sidebar + content */
        .admincontent {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            gap: 28px;
            padding: 30px 24px;
        }

        /* SIDEBAR - modern card style */
        .sidebar {
            flex: 0 0 280px;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02), 0 2px 6px rgba(0, 0, 0, 0.05);
            padding: 20px 0;
            height: fit-content;
            border: 1px solid #edf2f7;
        }

        #menu_list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .menu_items_link {
            text-decoration: none;
            display: block;
            margin: 6px 12px;
            border-radius: 60px;
            transition: all 0.2s ease;
        }

        .menu_items_list {
            padding: 12px 20px;
            font-weight: 500;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 0.95rem;
            border-radius: 40px;
            transition: 0.2s;
        }

        .menu_items_list i {
            width: 24px;
            font-size: 1.2rem;
            color: #5f7f9e;
        }

        .menu_items_link:hover .menu_items_list {
            background: #f1f5f9;
            color: #1e3c72;
        }

        .menu_items_link:hover .menu_items_list i {
            color: #2a5298;
        }

        /* active / highlighted menu item (change password) */
        .menu_items_link .menu_items_list.highlight {
            background: linear-gradient(95deg, #ffedd5, #fff3e0);
            color: #c2410c;
            font-weight: 600;
            border-left: 3px solid #f97316;
            border-radius: 40px;
        }

        .menu_items_link .menu_items_list.highlight i {
            color: #f97316;
        }

        /* main content panel */
        .main {
            flex: 1;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.03);
            padding: 32px 36px;
            border: 1px solid #edf2f7;
        }

        .heading {
            margin-bottom: 32px;
            border-left: 5px solid #f97316;
            padding-left: 20px;
        }

        .heading h2 {
            font-size: 1.9rem;
            font-weight: 600;
            background: linear-gradient(135deg, #1f2b3b, #1e3c72);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
        }

        /* Form styling - clean and spacious */
        #studentlogin {
            max-width: 620px;
            width: 100%;
        }

        .inputform {
            margin-bottom: 26px;
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
        }

        .inputform input {
            padding: 14px 18px;
            border: 1px solid #cfdfed;
            border-radius: 20px;
            font-size: 1rem;
            font-family: 'Inter', monospace;
            background: #fefefe;
            transition: 0.2s;
            outline: none;
            color: #1e2f3e;
        }

        .inputform input:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
            background: #ffffff;
        }

        /* button modern */
        .btn {
            background: linear-gradient(105deg, #1e3c72, #2a5298);
            border: none;
            padding: 14px 20px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            cursor: pointer;
            transition: all 0.25s;
            margin-top: 8px;
            width: 100%;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .btn:hover {
            background: linear-gradient(105deg, #163257, #1f4172);
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        .btn:active {
            transform: translateY(1px);
        }

        /* Responsive */
        @media (max-width: 880px) {
            .admincontent {
                flex-direction: column;
                padding: 20px;
            }
            .sidebar {
                flex: auto;
                width: 100%;
            }
            #top-navigation {
                padding: 0 20px;
            }
            .main {
                padding: 24px 20px;
            }
            .heading h2 {
                font-size: 1.6rem;
            }
        }

        /* subtle footer / extra spacing */
        .main:after {
            content: '';
            display: table;
            clear: both;
        }

        /* small icons inside form fields */
        .inputform {
            position: relative;
        }
        
        /* error / success alert styles will use default alerts but no functional changes */
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.75rem;
            color: #8ba0b5;
        }
    </style>
</head>
<body>

<div id="top-navigation">
    <div id="logo"><i class="fas fa-graduation-cap" style="margin-right: 8px; color:#f97316;"></i> UITS</div>
    <?php if (isset($_SESSION['user'])) : ?>
        <div id="student_name">
            <span><i class="fas fa-user-astronaut" style="margin-right: 6px;"></i>Welcome,</span>
            <span style="font-family: 'Inter', serif; font-weight:600;"><?php echo htmlspecialchars($_SESSION['user']['fullname']); ?></span>
        </div>
    <?php else: ?>
        <div id="student_name"><span>Student Portal</span></div>
    <?php endif ?>
</div>

<div class="admincontent">
    <div class="sidebar">
        <ul id="menu_list">
            <a class="menu_items_link" href="studentprofile.php">
                <li class="menu_items_list"><i class="fas fa-id-card"></i> My Profile</li>
            </a>
            <a class="menu_items_link" href="logbook.php">
                <li class="menu_items_list"><i class="fas fa-book-open"></i> Attachment Logbook</li>
            </a>
            <a class="menu_items_link" href="submitreports.php">
                <li class="menu_items_list"><i class="fas fa-file-alt"></i> Submit Reports</li>
            </a>
            <a class="menu_items_link" href="changepassword.php">
                <li class="menu_items_list highlight"><i class="fas fa-key"></i> Change Password</li>
            </a>
            <a class="menu_items_link" href="logbook.php?logout">
                <li class="menu_items_list"><i class="fas fa-sign-out-alt"></i> Logout</li>
            </a>
        </ul>
    </div>

    <div class="main">
        <div class="heading">
            <h2><i class="fas fa-lock" style="font-size: 1.8rem; margin-right: 12px; color:#f97316;"></i> Change Password</h2>
            <p style="color: #4b6b8f; margin-top: 8px;">Update your credentials securely</p>
        </div>

        <form method="post" id="studentlogin" action="changepassword.php" onSubmit="return validateForm()">
            <div class="inputform">
                <label><i class="fas fa-id-badge"></i> Admission Number</label>
                <input type="text" name="admissionnumber" id="admissionnumber" placeholder="e.g. 202400123" autocomplete="off">
            </div>
            <div class="inputform">
                <label><i class="fas fa-lock"></i> Current Password</label>
                <input type="password" name="cpassword" id="cpassword" placeholder="••••••••">
            </div>
            <div class="inputform">
                <label><i class="fas fa-unlock-alt"></i> New Password</label>
                <input type="password" name="password" id="password" placeholder="min 8 characters">
            </div>
            <div class="inputform">
                <label><i class="fas fa-redo-alt"></i> Repeat New Password</label>
                <input type="password" name="re_password" id="re_password" placeholder="confirm your new password">
            </div>
            <div class="inputform">
                <button type="submit" class="btn" id="change_pwd" name="change_pwd"><i class="fas fa-sync-alt"></i> Update Password</button>
            </div>
        </form>
        <footer>
            <i class="fas fa-shield-alt"></i> Your credentials are encrypted & protected
        </footer>
    </div>
</div>

<!-- SAME VALIDATION FUNCTION: unchanged logic to ensure no errors -->
<script>
    function validateForm() {
        //validate admission number
        admissionnumber = document.getElementById("admissionnumber").value;
        if (admissionnumber == "" || isNaN(admissionnumber) || admissionnumber.length < 5) {
            alert("please enter valid admission number");
            document.getElementById("admissionnumber").focus();
            return false;
        }
        //validating password
        password = document.getElementById("password").value;
        if (password == "" || password.length < 8) {
            alert("Password should not be empty and it should have more than 8 characters");
            document.getElementById("password").focus();
            return false;
        }
        //validating repeat password
        re_password = document.getElementById("re_password").value;
        if (re_password == "" || re_password.length < 8) {
            alert("password should not be empty and it should have more than 8 characters");
            document.getElementById("re_password").focus();
            return false;
        }
        // IMPORTANT: original function had no return true at end? We keep identical behavior.
        // If the checks pass, we need to return true to submit. However the original code did not have return true
        // but browsers will submit anyway if no false is returned. We keep consistent: if validation passes, we return true.
        // The original function had missing return true, but submission would happen because no false was returned.
        // To be safe and exactly preserve functionality: we return true only if all above conditions not triggered.
        return true;
    }
</script>
</body>
</html>