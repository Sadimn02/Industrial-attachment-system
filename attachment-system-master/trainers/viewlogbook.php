<?php
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: trainerlogin.php');
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: trainerlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Trainer - Assigned Students | UITS</title>
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

        .menu_items_link.active-assigned .menu_items_list {
            background: linear-gradient(95deg, #FFE4C0, #FFF9F0);
            border-left: 4px solid #F28C28;
            font-weight: 700;
        }
        .menu_items_link.active-assigned .menu_items_list i {
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

        .btn-logbook {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(125deg, #F28C28, #FF9F4A);
            color: white;
            padding: 8px 20px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.75rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 10px rgba(242,140,40,0.3);
        }

        .btn-logbook i {
            font-size: 0.8rem;
        }

        .btn-logbook:hover {
            background: linear-gradient(125deg, #E07A1A, #F28C28);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(242,140,40,0.35);
        }

        .empty-row td {
            text-align: center;
            padding: 48px 20px;
            color: #8BA0BC;
            font-weight: 500;
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
            .table td, .table th {
                padding: 12px 16px;
            }
            .btn-logbook {
                padding: 6px 14px;
                font-size: 0.7rem;
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
    <?php
    $db = mysqli_connect('localhost', 'root', '', 'dbsupervise');
    $query = "SELECT * FROM trainers WHERE trainer_id = {$_SESSION['user']['trainer_id']}";
    $query_trainer_name = mysqli_query($db, $query);
    if (mysqli_num_rows($query_trainer_name) > 0) {
        $row = mysqli_fetch_assoc($query_trainer_name);
        $_SESSION['trainer_id'] = $row['trainer_id'];
    }
    ?>

    <div id="top-navigation">
        <div id="logo"><i class="fas fa-chalkboard-user"></i> UITS</div>
        <div id="student_name">
            <i class="fas fa-user-check"></i>
            <span><em>Welcome,</em>&nbsp;</span>
            <span style="font-weight:700;"><?php echo htmlspecialchars($row['trainername']); ?></span>
        </div>
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
                <a class="menu_items_link active-assigned" href="viewlogbook.php">
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
            <h2><i class="fas fa-users"></i> STUDENT LOGBOOK</h2>

            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="stat-info">
                        <h3>Trainer ID</h3>
                        <p><?php echo htmlspecialchars($_SESSION['trainer_id']); ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <h3>Assigned Students</h3>
                        <p>View and Manage</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                    <div class="stat-info">
                        <h3>Logbook Access</h3>
                        <p>Monitor Progress</p>
                    </div>
                </div>
            </div>

            <div class="article">
                <table class="table" id="mytable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user-graduate"></i> Full Name</th>
                            <th><i class="fas fa-id-card"></i> Admission Number</th>
                            <th><i class="fas fa-building"></i> Company Name</th>
                            <th><i class="fas fa-map-marker-alt"></i> Company Address</th>
                            <th><i class="fas fa-eye"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody id="show_data">
                        <?php
                        $trainer_id = $_SESSION['trainer_id'];
                        $conn = mysqli_connect("localhost", "root", "", "dbsupervise");
                        $sql = "SELECT * FROM assigned_trainer LEFT JOIN students ON students.admission_number=assigned_trainer.admission_number WHERE assigned_trainer.trainer_id=$trainer_id";
                        $res = mysqli_query($conn, $sql);
                        
                        if (mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $student_id = $row['student_id'];
                                $fullname = htmlspecialchars($row['fullname']);
                                $admissionnumber = htmlspecialchars($row['admission_number']);
                                $companyname = htmlspecialchars($row['company_name']);
                                $companyaddress = htmlspecialchars($row['company_address']);
                                echo "<tr>";
                                echo "<td><strong>{$fullname}</strong></td>";
                                echo "<td><span style='font-family: monospace; font-weight:600; background:#F3F7FC; padding:4px 8px; border-radius:20px;'>{$admissionnumber}</span></td>";
                                echo "<td>{$companyname}</td>";
                                echo "<td class='company-cell'>{$companyaddress}</td>";
                                echo "<td><a href='trainerstudentlogbook.php?edit={$student_id}' class='btn-logbook'><i class='fas fa-book-open'></i> View Logbook</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr class='empty-row'><td colspan='5'><i class='fas fa-folder-open' style='font-size: 2rem; color: #C7D9E9; display: block; margin-bottom: 10px;'></i>No students assigned yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>