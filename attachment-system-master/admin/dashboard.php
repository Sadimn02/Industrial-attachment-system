<?php include "./includes/db.php";
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: adminlogin.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: adminlogin.php");
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UITS Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #64748b;
            --dark: #0f172a;
            --light: #f8fafc;
            --sidebar-width: 260px;
            --success: #22c55e;
            --warning: #f59e0b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: var(--dark); display: flex; }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--dark);
            height: 100vh;
            position: fixed;
            color: white;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #1e293b;
            color: var(--warning);
        }

        .sidebar ul { list-style: none; padding: 10px 0; }
        .sidebar ul a { text-decoration: none; color: #cbd5e1; }
        .sidebar ul li {
            padding: 12px 20px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar ul li:hover { background: #1e293b; color: white; }
        .active-link li { background: var(--primary) !important; color: white !important; border-radius: 0 25px 25px 0; margin-right: 10px; }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            width: 100%;
        }

        /* Top Nav */
        .top-nav {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .user-badge { font-weight: 600; color: var(--secondary); }
        .user-badge span { color: var(--primary); }

        /* Dashboard Content */
        .content-padding { padding: 30px; }
        .section-title { margin: 30px 0 15px 0; font-size: 1.2rem; color: var(--secondary); text-transform: uppercase; letter-spacing: 1px; }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 5px solid var(--primary);
        }

        .stat-card.allocated { border-left-color: var(--success); }
        .stat-card.unallocated { border-left-color: var(--warning); }

        .stat-card h4 { font-size: 0.85rem; color: var(--secondary); margin-bottom: 10px; }
        .stat-card h1 { font-size: 2rem; font-weight: 700; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-header, .menu-text { display: none; }
            .main-wrapper { margin-left: 70px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">UITS ADMIN</div>
        <ul id="menu_list">
            <a href="dashboard.php" class="active-link"><li><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></li></a>
            <a href="registeredstudents.php"><li><i class="fa-solid fa-user-graduate"></i><span class="menu-text">Registered Students</span></li></a>
            <a href="submitreports.php"><li><i class="fa-solid fa-file-contract"></i><span class="menu-text">Student Reports</span></li></a>
            <a href="attachmentlogbooks.php"><li><i class="fa-solid fa-book"></i><span class="menu-text">Logbooks</span></li></a>
            <a href="registeredsupervisors.php"><li><i class="fa-solid fa-user-tie"></i><span class="menu-text">Supervisors</span></li></a>
            <a href="assignedlecturers.php"><li><i class="fa-solid fa-link"></i><span class="menu-text">Assign Supervisors</span></li></a>
            <a href="registeredtrainers.php"><li><i class="fa-solid fa-chalkboard-user"></i><span class="menu-text">Registered Trainers</span></li></a>
            <a href="studentstrainers.php"><li><i class="fa-solid fa-users-between-lines"></i><span class="menu-text">Students' Trainers</span></li></a>
            <a href="studentslogs.php"><li><i class="fa-solid fa-history"></i><span class="menu-text">Student Logs</span></li></a>
            <a href="lecturerlogs.php"><li><i class="fa-solid fa-history"></i><span class="menu-text">Lecturer Logs</span></li></a>
            <a href="trainerlogs.php"><li><i class="fa-solid fa-history"></i><span class="menu-text">Trainer Logs</span></li></a>
            <a href="dashboard.php?logout" style="color: #f87171;"><li><i class="fa-solid fa-right-from-bracket"></i><span class="menu-text">Logout</span></li></a>
        </ul>
    </div>

    <div class="main-wrapper">
        <div class="top-nav">
            <div class="user-badge">Welcome, <span>Admin</span></div>
        </div>

        <div class="content-padding">
            <h2 class="section-title">Overview: Registered Users</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h4>REGISTERED LECTURERS</h4>
                    <?php
                        $conn = mysqli_connect('localhost', 'root', '', 'dbsupervise');
                        $query = "SELECT * FROM lecturers ORDER BY lecturer_id";
                        $query_run = mysqli_query($conn, $query);
                        echo '<h1>' . mysqli_num_rows($query_run) . '</h1>';
                    ?>
                </div>
                <div class="stat-card">
                    <h4>REGISTERED STUDENTS</h4>
                    <?php
                        $query = "SELECT * FROM students ORDER BY student_id";
                        $query_run = mysqli_query($conn, $query);
                        echo '<h1>' . mysqli_num_rows($query_run) . '</h1>';
                    ?>
                </div>
                <div class="stat-card">
                    <h4>REGISTERED TRAINERS</h4>
                    <?php
                        $query = "SELECT * FROM trainers ORDER BY trainer_id";
                        $query_run = mysqli_query($conn, $query);
                        echo '<h1>' . mysqli_num_rows($query_run) . '</h1>';
                    ?>
                </div>
            </div>

            <h2 class="section-title">Allocation Status (Assigned)</h2>
            <div class="stats-grid">
                <div class="stat-card allocated">
                    <h4>ALLOCATED LECTURERS</h4>
                    <?php
                        $query = "SELECT * FROM lecturers WHERE Allocated = 'YES'";
                        $query_run = mysqli_query($conn, $query);
                        echo '<h1>' . mysqli_num_rows($query_run) . '</h1>';
                    ?>
                </div>
                <div class="stat-card allocated">
                    <h4>ALLOCATED STUDENTS</h4>
                    <?php
                        $query = "SELECT * FROM students WHERE Allocated = 'YES'";
                        $query_run = mysqli_query($conn, $query);
                        echo '<h1>' . mysqli_num_rows($query_run) . '</h1>';
                    ?>
                </div>
            </div>

            <h2 class="section-title">Pending Allocation</h2>
            <div class="stats-grid">
                <div class="stat-card unallocated">
                    <h4>UNALLOCATED LECTURERS</h4>
                    <?php
                        $query = "SELECT * FROM lecturers WHERE Allocated = 'NO'";
                        $query_run = mysqli_query($conn, $query);
                        echo '<h1>' . mysqli_num_rows($query_run) . '</h1>';
                    ?>
                </div>
                <div class="stat-card unallocated">
                    <h4>UNALLOCATED STUDENTS</h4>
                    <?php
                        $query = "SELECT * FROM students WHERE Allocated = 'NO'";
                        $query_run = mysqli_query($conn, $query);
                        echo '<h1>' . mysqli_num_rows($query_run) . '</h1>';
                    ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>