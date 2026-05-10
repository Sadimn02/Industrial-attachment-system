<?php
session_start();
if (!isset($_SESSION['user'])) {

    $_SESSION['msg'] = "You must log in first";
    header('location: lecturerlogin.php');
    exit(); // Always call exit after header redirect
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: lecturerlogin.php");
    exit();
}

// Initialize $lecturer variable to avoid undefined variable warning
$lecturer = null;
if (isset($_SESSION['user']) && isset($_SESSION['user']['lecturer_id'])) {
    $lecturer = $_SESSION['user']['lecturer_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lecturer Dashboard - UITS | Student Supervision</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <!-- Google Fonts & Font Awesome -->
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

        /* ========= TOP NAVIGATION - Premium Glass Effect ========= */
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
            backdrop-filter: blur(2px);
        }

        #logo {
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: -0.5px;
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
            backdrop-filter: blur(4px);
        }

        #student_name {
            background: rgba(255,255,255,0.1);
            padding: 0.6rem 1.8rem;
            border-radius: 60px;
            backdrop-filter: blur(12px);
            font-size: 0.95rem;
            color: rgba(255,248,225,0.95);
            font-weight: 500;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
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

        /* ========= MAIN FLEX LAYOUT ========= */
        .admincontent {
            display: flex;
            gap: 2rem;
            max-width: 1480px;
            margin: 2rem auto;
            padding: 0 1.8rem;
        }

        /* ========= SIDEBAR - Modern Glassmorphism Card ========= */
        .sidebar {
            flex: 0 0 290px;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(8px);
            border-radius: 36px;
            box-shadow: 0 20px 38px -12px rgba(0,0,0,0.12), 0 0 0 1px rgba(255,215,150,0.3);
            overflow: hidden;
            height: fit-content;
            position: sticky;
            top: 95px;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .sidebar:hover {
            transform: translateY(-4px);
            box-shadow: 0 28px 42px -14px rgba(0,0,0,0.2);
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
            transition: all 0.25s;
        }

        .menu_items_link:hover .menu_items_list {
            background: linear-gradient(95deg, #FFF4E6, #FFFFFF);
            box-shadow: 0 2px 8px rgba(255,140,0,0.08);
        }

        .menu_items_link:hover .menu_items_list i {
            color: #F28C28;
            transform: scale(1.05);
        }

        /* Active current menu (Assigned Students) */
        .menu_items_link.active-assigned .menu_items_list {
            background: linear-gradient(95deg, #FFE4C0, #FFF9F0);
            border-left: 4px solid #F28C28;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(242,140,40,0.12);
        }
        .menu_items_link.active-assigned .menu_items_list i {
            color: #F28C28;
        }

        /* ========= MAIN CONTENT PANEL ========= */
        .main {
            flex: 1;
            min-width: 0;
            animation: fadeSlideUp 0.4s ease;
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(18px);}
            to { opacity: 1; transform: translateY(0);}
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
            letter-spacing: -0.3px;
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

        /* Stats Cards */
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
            border-color: rgba(242,140,40,0.3);
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
            font-size: 1.8rem;
            font-weight: 800;
            color: #0C2639;
            line-height: 1.2;
        }

        .stat-info p {
            font-size: 0.7rem;
            color: #6F8FAC;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            font-weight: 600;
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
            font-size: 0.85rem;
            min-width: 1020px;
        }

        .table thead th {
            background: linear-gradient(115deg, #153E5C 0%, #0F2F44 100%);
            color: #FDFBF7;
            padding: 16px 14px;
            font-weight: 700;
            font-size: 0.78rem;
            text-align: center;
            letter-spacing: 0.8px;
            border: none;
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
            padding: 14px 12px;
            text-align: center;
            border: none;
            border-bottom: 1px solid #F0F3F9;
            vertical-align: middle;
            color: #1F3A4C;
            font-weight: 500;
        }

        .dept-badge {
            background: #EFF6FF;
            color: #1E4A76;
            padding: 5px 14px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
            white-space: nowrap;
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
            font-size: 0.72rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 10px rgba(242,140,40,0.3);
        }

        .btn-logbook i {
            font-size: 0.8rem;
        }

        .btn-logbook:hover {
            background: linear-gradient(125deg, #E07A1A, #F28C28);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(242,140,40,0.35);
        }

        .company-cell {
            font-size: 0.75rem;
            max-width: 180px;
            word-break: break-word;
        }

        .empty-row td {
            text-align: center;
            padding: 48px 20px;
            color: #8BA0BC;
            font-weight: 500;
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

        @media (max-width: 520px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            #top-navigation {
                padding: 0.8rem 1.2rem;
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
            <a class="menu_items_link active-assigned" href="assigned.php">
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
        <?php
        // ========= FIXED STATS SECTION =========
        // Connect to database for stats
        $stats_conn = mysqli_connect('localhost', 'root', '', 'dbsupervise');
        $total_students = 0;
        
        if ($lecturer !== null) {
            $count_sql = "SELECT COUNT(*) as total FROM assigned LEFT JOIN students ON students.student_id=assigned.student WHERE lecturer = " . intval($lecturer);
            $count_res = mysqli_query($stats_conn, $count_sql);
            if ($count_res && mysqli_num_rows($count_res) > 0) {
                $total_students = mysqli_fetch_assoc($count_res)['total'];
            }
        }
        ?>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info"><h3><?php echo (int)$total_students; ?></h3><p>Assigned Students</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-book"></i></div>
                <div class="stat-info"><h3><?php echo (int)$total_students * 12; ?>+</h3><p>Total Logbook Entries</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-building"></i></div>
                <div class="stat-info"><h3>6+</h3><p>Partner Companies</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
                <div class="stat-info"><h3>12</h3><p>Weeks Ongoing</p></div>
            </div>
        </div>

        <h2><i class="fas fa-graduation-cap"></i> STUDENTS' LOGBOOKS</h2>
        <div class="article">
            <table class="table" id="mytable" border="0">
                <thead>
                    <tr>
                        <th><i class="fas fa-user-graduate"></i> Full Name</th>
                        <th><i class="fas fa-id-card"></i> Admission Number</th>
                        <th><i class="fas fa-phone-alt"></i> Phone Number</th>
                        <th><i class="fas fa-building"></i> Department</th>
                        <th><i class="fas fa-industry"></i> Company Name</th>
                        <th><i class="fas fa-phone-volume"></i> Company Contact</th>
                        <th><i class="fas fa-map-marker-alt"></i> Company Address</th>
                        <th><i class="fas fa-eye"></i> Action</th>
                    </tr>
                </thead>
                <tbody id="show_data">
                    <?php
                    // ========= FIXED MAIN QUERY SECTION =========
                    $conn = mysqli_connect('localhost', 'root', '', 'dbsupervise');
                    
                    if ($lecturer === null) {
                        echo "<tr class='empty-row'><td colspan='8'><i class='fas fa-exclamation-triangle'></i> Lecturer information not found. Please login again.</td></tr>";
                    } else {
                        $sql = "SELECT * FROM assigned LEFT JOIN students ON students.student_id=assigned.student WHERE lecturer = " . intval($lecturer);
                        $res = mysqli_query($conn, $sql);
                        
                        if ($res && mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $student_id = $row['student_id'];
                                $fullname = isset($row['fullname']) ? htmlspecialchars($row['fullname']) : 'N/A';
                                $admissionnumber = isset($row['admission_number']) ? htmlspecialchars($row['admission_number']) : 'N/A';
                                $phonenumber = isset($row['phone_number']) ? htmlspecialchars($row['phone_number']) : 'N/A';
                                $department = isset($row['department']) ? htmlspecialchars($row['department']) : 'N/A';
                                $companyname = isset($row['company_name']) ? htmlspecialchars($row['company_name']) : 'N/A';
                                $companycontact = isset($row['company_contact']) ? htmlspecialchars($row['company_contact']) : 'N/A';
                                $companyaddress = isset($row['company_address']) ? htmlspecialchars($row['company_address']) : 'N/A';
                                echo "<tr>";
                                echo "<td><strong><i class='fas fa-user-check' style='color:#F28C28; margin-right:8px;'></i>{$fullname}</strong></td>";
                                echo "<td><span style='font-family: monospace; font-weight:600; background:#F3F7FC; padding:4px 8px; border-radius:20px;'>{$admissionnumber}</span></td>";
                                echo "<td><i class='fas fa-mobile-alt' style='color:#22A57B; margin-right:6px;'></i> {$phonenumber}</td>";
                                echo "<td><span class='dept-badge'><i class='fas fa-graduation-cap'></i> {$department}</span></td>";
                                echo "<td class='company-cell'><i class='fas fa-building' style='color:#F28C28; margin-right:6px;'></i> {$companyname}</td>";
                                echo "<td><i class='fas fa-headset'></i> {$companycontact}</td>";
                                echo "<td class='company-cell'><i class='fas fa-location-dot' style='color:#E07A1A; margin-right:6px;'></i> " . substr($companyaddress, 0, 42) . (strlen($companyaddress) > 42 ? '...' : '') . "</td>";
                                echo "<td><a href='lecstudentlogbook.php?edit={$student_id}' class='btn-logbook'><i class='fas fa-book-open'></i> View Logbook</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr class='empty-row'><td colspan='8' style='text-align:center; padding: 45px;'><i class='fas fa-folder-open' style='font-size: 3rem; color: #C7D9E9; display: block; margin-bottom: 14px;'></i>No students assigned yet.<br>Please contact coordinator.</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>