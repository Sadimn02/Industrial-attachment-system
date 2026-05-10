<?php
session_start();
include "./includes/db.php";

//change password

if (isset($_POST['change_pwd'])) {
    $role_id = $_POST['role_id'];
    $cpassword = $_POST['cpassword'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    $cpassword = md5($cpassword);

    $stmt = "SELECT * FROM lecturers WHERE role_id='$role_id' and password='$cpassword'"; #check for a user with the same username and password
    $result = mysqli_query($conn, $stmt);/* execute the query */
    $rows = mysqli_num_rows($result);/* count the number of arrays returened by the query */
    if ($rows !== 1) #if current credentials are wrong
    {
        echo "<script>alert('Invalid username or password')</script>";
    } elseif ($password == $re_password) {
        $password = md5($password);
        $sql = "UPDATE lecturers SET password='$password' WHERE role_id='$role_id' ";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            //insert into logs
            $lecturer_id = $_SESSION['user']['lecturer_id'];
            $date = date('Y-m-d H:i:s');
            $stmt3 = "INSERT INTO lecturerlogs(lecturer_id,action,time) VALUES('$lecturer_id','Change password','$date')";
            $query = mysqli_query($conn, $stmt3);

            session_destroy();
            echo "<script>alert('Password updated successfully. Please login again.');window.location = 'lecturerlogin.php'</script>";
        } else {
            echo "<script>alert('Failed to Update password');window.location = 'changepassword.php'</script>";
        }
    } else {
        echo "<script>alert('The two passwords do not match');window.location = 'changepassword.php'</script>";
    }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password - UITS Lecturer</title>
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

        /* TOP NAVIGATION */
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

        /* MAIN LAYOUT */
        .admincontent {
            display: flex;
            gap: 2rem;
            max-width: 1480px;
            margin: 2rem auto;
            padding: 0 1.8rem;
        }

        /* SIDEBAR */
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

        /* Active menu item (Change Password) */
        .menu_items_link.active-password .menu_items_list {
            background: linear-gradient(95deg, #FFE4C0, #FFF9F0);
            border-left: 4px solid #F28C28;
            font-weight: 700;
        }
        .menu_items_link.active-password .menu_items_list i {
            color: #F28C28;
        }

        /* MAIN CONTENT - same as assigned.php */
        .main {
            flex: 1;
            min-width: 0;
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
            left: 0;
            width: 70px;
            height: 4px;
            background: linear-gradient(90deg, #F28C28, #FFD28F);
            border-radius: 8px;
        }

        /* Stats Cards - same styling as assigned.php */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.3rem;
            margin-bottom: 2.5rem;
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

        /* Article / Table Card - same as assigned.php */
        .article {
            background: white;
            border-radius: 32px;
            overflow-x: auto;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08);
            border: 1px solid #ECF2F9;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.85rem;
        }

        .table thead th {
            background: linear-gradient(115deg, #153E5C 0%, #0F2F44 100%);
            color: #FDFBF7;
            padding: 16px 20px;
            font-weight: 700;
            font-size: 0.85rem;
            text-align: left;
        }

        .table thead th:first-child {
            border-top-left-radius: 32px;
        }

        .table thead th:last-child {
            border-top-right-radius: 32px;
        }

        .table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #F0F4FA;
        }

        .table tbody tr:hover {
            background: #FFFBF5;
        }

        .table td {
            padding: 16px 20px;
            border: none;
            border-bottom: 1px solid #F0F3F9;
            vertical-align: middle;
            color: #1F3A4C;
            font-weight: 500;
        }

        .inputform {
            margin: 0;
        }

        .inputform input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cfdfed;
            border-radius: 16px;
            font-size: 0.9rem;
            font-family: 'Inter', monospace;
            background: #fefefe;
            transition: 0.2s;
            outline: none;
        }

        .inputform input:focus {
            border-color: #F28C28;
            box-shadow: 0 0 0 3px rgba(242,140,40,0.1);
        }

        .password-hint {
            font-size: 0.7rem;
            color: #8a99b0;
            margin-top: 0.4rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-update {
            background: linear-gradient(125deg, #F28C28, #FF9F4A);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(242,140,40,0.3);
        }

        .btn-update:hover {
            background: linear-gradient(125deg, #E07A1A, #F28C28);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .admincontent {
                flex-direction: column;
                padding: 0 1.2rem;
            }
            .sidebar {
                position: static;
                width: 100%;
            }
        }

        @media (max-width: 520px) {
            #top-navigation {
                padding: 0.8rem 1.2rem;
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
            <span style="font-weight:700;"><?php echo htmlspecialchars($_SESSION['user']['lecname']); ?></span>
        </div>
    <?php endif ?>
</div>

<div class="admincontent">
    <div class="sidebar">
        <ul id="menu_list">
            <a class="menu_items_link" href="lecturerprofile.php">
                <li class="menu_items_list"><i class="fas fa-user-circle"></i> My Profile</li>
            </a>
            <a class="menu_items_link" href="assigned.php">
                <li class="menu_items_list"><i class="fas fa-users"></i> Assigned Students</li>
            </a>
            <a class="menu_items_link" href="assigned.php">
                <li class="menu_items_list"><i class="fas fa-book-open"></i> Students' Logbooks</li>
            </a>
            <a class="menu_items_link active-password" href="changepassword.php">
                <li class="menu_items_list"><i class="fas fa-key"></i> Change Password</li>
            </a>
            <a class="menu_items_link" href="assigned.php?logout">
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

        <div class="article">
            <form method="post" action="changepassword.php" onSubmit="return validateForm()">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2"><i class="fas fa-edit"></i> Password Update Form</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 30%;"><label><i class="fas fa-id-badge"></i> Role ID</label></td>
                            <td>
                                <div class="inputform">
                                    <input type="text" name="role_id" id="role_id" placeholder="Enter your Role ID">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label><i class="fas fa-shield-alt"></i> Current Password</label></td>
                            <td>
                                <div class="inputform">
                                    <input type="password" name="cpassword" id="cpassword" placeholder="Enter current password">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label><i class="fas fa-key"></i> New Password</label></td>
                            <td>
                                <div class="inputform">
                                    <input type="password" name="password" id="password" placeholder="Enter new password">
                                    <div class="password-hint">
                                        <i class="fas fa-info-circle"></i> Password must be at least 8 characters
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label><i class="fas fa-redo-alt"></i> Repeat New Password</label></td>
                            <td>
                                <div class="inputform">
                                    <input type="password" name="re_password" id="re_password" placeholder="Confirm new password">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right;">
                                <button type="submit" class="btn-update" name="change_pwd" id="change_pwd">
                                    <i class="fas fa-save"></i> Update Password
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<script>
    // Original validateForm function - COMPLETELY UNCHANGED
    function validateForm() {
        //validate role_id
        role_id = document.getElementById("role_id").value;
        if (role_id == "" || role_id.length < 4) {
            alert("Please enter your Role ID");
            document.getElementById("role_id").focus();
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
        return true;
    }
</script>
</body>
</html>