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
    <title>Trainer - Add Student | UITS</title>
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

        .menu_items_link.active-add .menu_items_list {
            background: linear-gradient(95deg, #FFE4C0, #FFF9F0);
            border-left: 4px solid #F28C28;
            font-weight: 700;
        }
        .menu_items_link.active-add .menu_items_list i {
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

        .form-container {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #4a627a;
            margin-bottom: 8px;
            display: block;
        }

        .form-group label i {
            margin-right: 8px;
            color: #F28C28;
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #cfdfed;
            border-radius: 20px;
            font-size: 0.95rem;
            font-family: 'Inter', monospace;
            background: #fefefe;
            transition: 0.2s;
            outline: none;
        }

        .form-group input:focus {
            border-color: #F28C28;
            box-shadow: 0 0 0 3px rgba(242,140,40,0.1);
        }

        hr {
            margin: 1rem 0;
            border: 0;
            height: 1px;
            background: #e9eef3;
        }

        .btn-save {
            background: linear-gradient(125deg, #F28C28, #FF9F4A);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 12px rgba(242,140,40,0.25);
        }

        .btn-save:hover {
            background: linear-gradient(125deg, #E07A1A, #F28C28);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(242,140,40,0.35);
        }

        .alert-message {
            padding: 12px 20px;
            border-radius: 16px;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .alert-success {
            background: #e0f2e9;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border-left: 4px solid #f59e0b;
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
            .form-container {
                padding: 1.5rem;
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
                <a class="menu_items_link active-add" href="assignedtrainer.php">
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
            <h2><i class="fas fa-user-plus"></i> ADD STUDENT</h2>

            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-id-card"></i></div>
                    <div class="stat-info">
                        <h3>Admission Number</h3>
                        <p>Enter Student ID</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="stat-info">
                        <h3>Trainer ID</h3>
                        <p><?php echo htmlspecialchars($_SESSION['user']['trainer_id']); ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div class="stat-info">
                        <h3>Assignment</h3>
                        <p>Student-Trainer</p>
                    </div>
                </div>
            </div>

            <div class="article">
                <div class="form-container">
                    <form action="assignedtrainer.php" method="post">
                        <div class="form-group">
                            <label><i class="fas fa-id-badge"></i> Admission Number:</label>
                            <input type="text" name="admission_number" placeholder="Enter student admission number" required>
                        </div>
                        <hr>
                        <button type="submit" name="savechanges" class="btn-save">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </form>

                    <?php
                    $db = mysqli_connect("localhost", "root", "", "dbsupervise");
                    if (isset($_POST['savechanges'])) {
                        $admissionnumber = mysqli_real_escape_string($db, $_POST['admission_number']);
                        $trainer_id = $_SESSION['user']['trainer_id'];
                        
                        $check_select = "SELECT * FROM `assigned_trainer` WHERE admission_number = '$admissionnumber' AND trainer_id = '$trainer_id'";
                        $result = mysqli_query($db, $check_select);
                        $numrows = mysqli_num_rows($result);
                        
                        if ($numrows > 0) {
                            echo '<div class="alert-message alert-warning"><i class="fas fa-exclamation-triangle"></i> Student already assigned to a trainer</div>';
                        } else {
                            $query = "INSERT INTO assigned_trainer(admission_number, trainer_id) VALUES('$admissionnumber','$trainer_id')";
                            $create_post_query = mysqli_query($db, $query);
                            
                            if ($create_post_query) {
                                echo '<div class="alert-message alert-success"><i class="fas fa-check-circle"></i> Valid Admission Number! Proceed to view Student logbook</div>';
                            } else {
                                echo '<div class="alert-message alert-error"><i class="fas fa-times-circle"></i> Enter A Valid Admission Number</div>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>