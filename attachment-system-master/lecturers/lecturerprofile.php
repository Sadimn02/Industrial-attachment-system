<?php
include "./includes/db.php";
session_start();
//no one can access this page apart from the lecturers /(security)
if ($_SESSION['utype'] == 'lecturer') {
} else {
    echo "<script>alert('You must login first')</script>";
    echo "<script>location.href='lecturerlogin.php'</script>";
}

if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: lecturerlogin.php');
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: lecturerlogin.php");
    exit();
}
$role_id = $_SESSION['user']['role_id'];
$q = mysqli_query($conn, "SELECT * FROM lecturers WHERE role_id = '$role_id'");
$row = mysqli_fetch_assoc($q);
$lecname = $row['lecname'];
$role_id = $row['role_id'];
$email = $row['email'];
$phonenumber = $row['phonenumber'];
$department = $row['department'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lecturer Profile - UITS</title>
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

        /* Active menu item */
        .menu_items_link.active-profile .menu_items_list {
            background: linear-gradient(95deg, #FFE4C0, #FFF9F0);
            border-left: 4px solid #F28C28;
            font-weight: 700;
        }
        .menu_items_link.active-profile .menu_items_list i {
            color: #F28C28;
        }

        /* MAIN CONTENT */
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

        /* Stats Cards - Fixed for text overflow */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
            min-width: 0;
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
            flex-shrink: 0;
        }

        .stat-icon i {
            font-size: 1.6rem;
            color: #F28C28;
        }

        .stat-info {
            flex: 1;
            min-width: 0;
        }

        .stat-info h3 {
            font-size: 0.9rem;
            font-weight: 700;
            color: #6F8FAC;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stat-info p {
            font-size: 1rem;
            font-weight: 600;
            color: #0C2639;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.3;
        }

        /* Table Card */
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
            font-size: 0.9rem;
        }

        .table thead th {
            background: linear-gradient(115deg, #153E5C 0%, #0F2F44 100%);
            color: #FDFBF7;
            padding: 16px 20px;
            font-weight: 700;
            font-size: 0.85rem;
            text-align: left;
            letter-spacing: 0.5px;
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

        .table td:first-child {
            font-weight: 700;
            color: #0C2639;
            width: 30%;
        }

        .dept-badge {
            background: #EFF6FF;
            color: #1E4A76;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .admincontent {
                gap: 1.4rem;
            }
            .sidebar {
                flex: 0 0 260px;
            }
        }

        @media (max-width: 830px) {
            .admincontent {
                flex-direction: column;
                padding: 0 1.2rem;
            }
            .sidebar {
                position: static;
                width: 100%;
            }
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            #top-navigation {
                padding: 0.8rem 1.2rem;
            }
            .table td, .table th {
                padding: 12px 15px;
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
            <a class="menu_items_link active-profile" href="lecturerprofile.php">
                <li class="menu_items_list"><i class="fas fa-user-circle"></i> My Profile</li>
            </a>
            <a class="menu_items_link" href="assigned.php">
                <li class="menu_items_list"><i class="fas fa-users"></i> Assigned Students</li>
            </a>
            <a class="menu_items_link" href="assigned.php">
                <li class="menu_items_list"><i class="fas fa-book-open"></i> Students' Logbooks</li>
            </a>
            <a class="menu_items_link" href="changepassword.php">
                <li class="menu_items_list"><i class="fas fa-key"></i> Change Password</li>
            </a>
            <a class="menu_items_link" href="assigned.php?logout">
                <li class="menu_items_list"><i class="fas fa-sign-out-alt"></i> Logout</li>
            </a>
        </ul>
    </div>

    <div class="main">
        <h2><i class="fas fa-user-circle"></i> MY PROFILE</h2>
        
        <!-- Stats Cards Section -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="stat-info">
                    <h3>Full Name</h3>
                    <p><?php echo htmlspecialchars($lecname); ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-building"></i></div>
                <div class="stat-info">
                    <h3>Department</h3>
                    <p><?php echo htmlspecialchars($department); ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-id-badge"></i></div>
                <div class="stat-info">
                    <h3>Role ID</h3>
                    <p><?php echo htmlspecialchars($role_id); ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-phone-alt"></i></div>
                <div class="stat-info">
                    <h3>Phone Number</h3>
                    <p><?php echo htmlspecialchars($phonenumber); ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                <div class="stat-info">
                    <h3>Email</h3>
                    <p style="word-break: break-all;"><?php echo htmlspecialchars($email); ?></p>
                </div>
            </div>
        </div>

        <!-- Profile Details Table -->
        <div class="article">
            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fas fa-info-circle"></i> Field</th>
                        <th><i class="fas fa-user"></i> Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Full Name</strong></td>
                        <td><?php echo htmlspecialchars($lecname); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Role ID</strong></td>
                        <td><?php echo htmlspecialchars($role_id); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email Address</strong></td>
                        <td style="word-break: break-all;"><?php echo htmlspecialchars($email); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Phone Number</strong></td>
                        <td><?php echo htmlspecialchars($phonenumber); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Department</strong></td>
                        <td><span class="dept-badge"><?php echo htmlspecialchars($department); ?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>