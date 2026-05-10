<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Fix the include path - adjust based on your actual file structure
include __DIR__ . "/includes/db.php";  // __DIR__ is the current directory

session_start();

// Check if user is logged in and is a trainer
if (!isset($_SESSION['user']) || $_SESSION['utype'] != 'trainer') {
    echo "<script>alert('You must login first'); location.href='trainerlogin.php';</script>";
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: trainerlogin.php");
    exit();
}

// Check if $db exists
if (!isset($db) || !$db) {
    die("Database connection failed. Please check db.php file.");
}

$email = $_SESSION['user']['email'];

// Use prepared statement for security
$query = "SELECT * FROM trainers WHERE email = ?";
$stmt = mysqli_prepare($db, $query);

if (!$stmt) {
    die("Query preparation failed: " . mysqli_error($db));
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($row) {
    $trainername = $row['trainername'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $title = $row['title'];
} else {
    echo "<script>alert('Trainer not found'); location.href='trainerlogin.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Trainer Profile - UITS</title>
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

        .menu_items_link.active-profile .menu_items_list {
            background: linear-gradient(95deg, #FFE4C0, #FFF9F0);
            border-left: 4px solid #F28C28;
            font-weight: 700;
        }
        .menu_items_link.active-profile .menu_items_list i {
            color: #F28C28;
        }

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
            word-break: break-word;
        }

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
            padding: 16px 24px;
            font-weight: 700;
            font-size: 0.9rem;
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
            padding: 16px 24px;
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
            background-color: #FAFCFE;
        }

        .table td:first-child i {
            margin-right: 10px;
            color: #F28C28;
            width: 20px;
        }

        .info-note {
            background: #FFF8F0;
            border-left: 4px solid #F28C28;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: #6F8FAC;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-note i {
            color: #F28C28;
            font-size: 1rem;
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
        }

        @media (max-width: 600px) {
            #top-navigation {
                padding: 0.8rem 1.2rem;
            }
            .stats-container {
                grid-template-columns: 1fr;
            }
            .table td {
                padding: 12px 16px;
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
                <a class="menu_items_link active-profile" href="trainerprofile.php">
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
                <a class="menu_items_link" href="changepassword.php">
                    <li class="menu_items_list"><i class="fas fa-key"></i> Change Password</li>
                </a>
                <a class="menu_items_link" href="assignedtrainer.php?logout">
                    <li class="menu_items_list"><i class="fas fa-sign-out-alt"></i> Logout</li>
                </a>
            </ul>
        </div>

        <div class="main">
            <h2><i class="fas fa-user-circle"></i> MY PROFILE</h2>

            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="stat-info">
                        <h3>Trainer Name</h3>
                        <p><?php echo htmlspecialchars($trainername); ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                    <div class="stat-info">
                        <h3>Email Address</h3>
                        <p><?php echo htmlspecialchars($email); ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="stat-info">
                        <h3>Mobile Number</h3>
                        <p><?php echo htmlspecialchars($mobile); ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-certificate"></i></div>
                    <div class="stat-info">
                        <h3>Title</h3>
                        <p><?php echo htmlspecialchars($title); ?></p>
                    </div>
                </div>
            </div>

            <div class="article">
                <form method="post" action="">
                    <table class="table">
                        <thead>
                            <tr><th colspan="2"><i class="fas fa-info-circle"></i> TRAINER DETAILS</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fas fa-user"></i> Trainer Full Name</td>
                                <td><?php echo htmlspecialchars($trainername); ?></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-envelope"></i> Email</td>
                                <td><?php echo htmlspecialchars($email); ?></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-phone-alt"></i> Mobile</td>
                                <td><?php echo htmlspecialchars($mobile); ?></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-certificate"></i> Title</td>
                                <td><?php echo htmlspecialchars($title); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="info-note">
                <i class="fas fa-info-circle"></i>
                <span>To update your profile information, please contact the system administrator.</span>
            </div>
        </div>
    </div>
</body>
</html>