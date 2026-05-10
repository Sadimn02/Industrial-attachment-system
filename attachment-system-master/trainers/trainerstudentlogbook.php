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
include "trainer_logbook_functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Logbook | UITS Trainer Panel</title>
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

        #logo:before {
            content: "\f0eb";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            background: rgba(255,255,255,0.12);
            padding: 10px;
            border-radius: 16px;
            font-size: 1.2rem;
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

        #student_name span:first-child em {
            font-style: normal;
            font-weight: 400;
            color: #FFD966;
        }

        #student_name span:last-child {
            font-weight: 700;
            color: white;
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

        .menu_items_list:before {
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            width: 28px;
            font-size: 1.1rem;
            color: #6C86A3;
        }

        .menu_items_link:nth-child(1) .menu_items_list:before { content: "\f2bd"; }
        .menu_items_link:nth-child(2) .menu_items_list:before { content: "\f234"; }
        .menu_items_link:nth-child(3) .menu_items_list:before { content: "\f0c0"; }
        .menu_items_link:nth-child(4) .menu_items_list:before { content: "\f02d"; }
        .menu_items_link:nth-child(5) .menu_items_list:before { content: "\f084"; }
        .menu_items_link:nth-child(6) .menu_items_list:before { content: "\f08b"; }

        .menu_items_link:hover .menu_items_list {
            background: linear-gradient(95deg, #FFF4E6, #FFFFFF);
        }

        .menu_items_link:hover .menu_items_list:before {
            color: #F28C28;
        }

        .menu_items_link.active .menu_items_list {
            background: linear-gradient(95deg, #FFE4C0, #FFF9F0);
            border-left: 4px solid #F28C28;
            font-weight: 700;
        }
        .menu_items_link.active .menu_items_list:before {
            color: #F28C28;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        /* Logbook Navigation Card */
        .logbook-nav-card {
            background: white;
            border-radius: 28px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            border: 1px solid rgba(242,140,40,0.12);
        }

        .form-group-row {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #F28C28;
            margin-bottom: 8px;
        }

        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cfdfed;
            border-radius: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            background: #fefefe;
            cursor: pointer;
            transition: 0.2s;
        }

        .form-group select:focus {
            outline: none;
            border-color: #F28C28;
            box-shadow: 0 0 0 3px rgba(242,140,40,0.1);
        }

        .comment-section {
            background: linear-gradient(135deg, #FFF9F0, #FFFFFF);
            border-radius: 24px;
            padding: 1.5rem;
            margin-top: 1rem;
            border: 1px solid #FFE0B5;
        }

        .comment-label {
            font-weight: 700;
            font-size: 0.85rem;
            color: #1C2F41;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .comment-label i {
            color: #F28C28;
            font-size: 1rem;
        }

        .readonly-input-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .readonly-input-group input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e0e8f0;
            border-radius: 16px;
            background: #f8fafd;
            font-family: 'Inter', monospace;
            font-size: 0.85rem;
            color: #4a627a;
        }

        textarea.trainer-comment {
            width: 100%;
            padding: 16px;
            border: 1px solid #cfdfed;
            border-radius: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            resize: vertical;
            min-height: 100px;
            transition: 0.2s;
        }

        textarea.trainer-comment:focus {
            outline: none;
            border-color: #F28C28;
            box-shadow: 0 0 0 3px rgba(242,140,40,0.1);
        }

        .btn-save {
            background: linear-gradient(125deg, #F28C28, #FF9F4A);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 1rem;
        }

        .btn-save:hover {
            background: linear-gradient(125deg, #E07A1A, #F28C28);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(242,140,40,0.35);
        }

        hr {
            margin: 1rem 0;
            border: none;
            height: 1px;
            background: linear-gradient(90deg, transparent, #FFD28F, transparent);
        }

        /* Table Styles */
        .article {
            background: white;
            border-radius: 32px;
            padding: 1.5rem;
            overflow-x: auto;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08);
        }

        .logbook-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.85rem;
            border-radius: 20px;
            overflow: hidden;
        }

        .logbook-table th {
            background: linear-gradient(135deg, #0a1c2c, #0f2f44);
            color: white;
            padding: 14px 10px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            border: none;
        }

        .logbook-table td {
            padding: 12px 8px;
            text-align: center;
            border-bottom: 1px solid #eef2f8;
            vertical-align: middle;
        }

        .logbook-table tr:hover td {
            background-color: #FFF9F0;
        }

        .status-completed {
            background: linear-gradient(135deg, #1B8C3E, #28A745);
            color: white;
            padding: 6px 10px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: linear-gradient(135deg, #DC3545, #E4606D);
            color: white;
            padding: 6px 10px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
        }

        .day-notes {
            font-size: 0.8rem;
            font-weight: 500;
            color: #1C2F41;
            margin-bottom: 4px;
        }

        .timestamp {
            font-size: 0.65rem;
            color: #6C86A3;
            display: block;
            margin-top: 4px;
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
            .form-group-row {
                flex-direction: column;
            }
        }

        @media (max-width: 600px) {
            #top-navigation {
                padding: 0.8rem 1.2rem;
            }
            .logbook-table th, .logbook-table td {
                padding: 8px 4px;
                font-size: 0.7rem;
            }
        }
    </style>
</head>

<body>
    <?php
    // Database connection (original)
    $db = mysqli_connect("localhost", "root", "", "dbsupervise");
    $query = "SELECT * FROM tbl_weeks";
    $select_all_weeks = mysqli_query($db, $query);
    ?>
    
    <div id="top-navigation">
        <div id="logo"> UITS</div>
        <?php if (isset($_SESSION['user'])) : ?>
            <div id="student_name">
                <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp;</span>
                <span style="font-family:serif"><?php echo htmlspecialchars($_SESSION['user']['trainername']); ?></span>
            </div>
        <?php endif ?>
    </div>

    <div class="admincontent">
        <div class="sidebar">
            <ul id="menu_list">
                <a class="menu_items_link" href="trainerprofile.php">
                    <li class="menu_items_list">My Profile</li>
                </a>
                <a class="menu_items_link" href="assignedtrainer.php">
                    <li class="menu_items_list">Add Students</li>
                </a>
                <a class="menu_items_link" href="viewlogbook.php">
                    <li class="menu_items_list">Assigned Students</li>
                </a>
                <a class="menu_items_link active" href="lecstudentlogbook.php">
                    <li class="menu_items_list">Students' Logbooks</li>
                </a>
                <a class="menu_items_link" href="changepassword.php">
                    <li class="menu_items_list">Change Password</li>
                </a>
                <a class="menu_items_link" href="assignedtrainer.php?logout">
                    <li class="menu_items_list">Logout</li>
                </a>
            </ul>
        </div>

        <div class="main">
            <form method="post" action="trainerstudentlogbook.php">
                <div class="logbook-nav-card">
                    <div class="form-group-row">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-week"></i> SELECT WEEK</label>
                            <select class="form-control" name="week_id" id="weeks">
                                <option value="">--- Choose Week ---</option>
                                <?php foreach ($select_all_weeks as $row) : ?>
                                    <option value="<?php echo $row['week_id']; ?>"><?php echo htmlspecialchars($row['week_title']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="comment-section">
                        <div class="comment-label">
                            <i class="fas fa-comment-dots"></i> TRAINER FEEDBACK
                        </div>
                        <?php
                        if (isset($_GET['edit'])) {
                            $students = $_GET['edit'];
                        }
                        ?>
                        <div class="readonly-input-group">
                            <input type="text" name="trainer_comment" class="lec" value="TRAINER_COMMENT" placeholder="TRAINER COMMENT" readonly />
                            <input type="text" name="students" class="lec" value="<?php echo isset($students) ? htmlspecialchars($students) : ''; ?>" placeholder="Student ID" readonly />
                        </div>
                        <textarea style="width: 100%;" type="text" name="trainer_coment_notes" class="trainer-comment" placeholder="Write your remarks / feedback for the student here..."></textarea>
                        
                        <button type="submit" style="background: linear-gradient(125deg, #F28C28, #FF9F4A);" name="create_trainer_comment" class="btn-save">
                            <i class="fas fa-paper-plane"></i> SUBMIT TRAINER REMARK
                        </button>
                        <hr>
                    </div>
                </div>
            </form>

            <div class="article">
                <table class="logbook-table" width="100%" id="mytable" border="0">
                    <thead>
                        <tr>
                            <th>Week</th>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
                            <th>Saturday</th>
                            <th>Lecturer Remarks</th>
                            <th>Trainer Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="show_data">
                        <?php
                        if (isset($_GET['edit'])) {
                            $student_id = $_GET['edit'];
                            $_SESSION['student'] = $student_id;
                        }
                        // populate logbook data (ORIGINAL LOGIC - UNCHANGED)
                        foreach ($select_all_weeks as $key => $t) {
                            echo "<tr>";
                            echo "<td><strong>" . htmlspecialchars($t['week_title']) . "</strong></td>";
                            $conn = mysqli_connect("localhost", "root", "", "dbsupervise");
                            $query12 = "SELECT * FROM logbookdata WHERE week_id='" . $t['week_id'] . "' AND student_id='" . $student_id . "' ";
                            $res = mysqli_query($conn, $query12);
                            $week_days = array('MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'LEC_COMMENT', 'TRAINER_COMMENT');
                            $classes = array();
                            while ($row = mysqli_fetch_assoc($res)) {
                                $classes[$row['day_title']] = $row;
                            }
                            foreach ($week_days as $day) {
                                if (array_key_exists($day, $classes)) {
                                    $row = $classes[$day];
                                    echo "<td style='background-color:#E8F5E9;'>";
                                    echo "<div class='day-notes'>" . htmlspecialchars($row['day_notes']) . "</div>";
                                    echo "<div class='timestamp'>" . htmlspecialchars($row['created_at']) . "</div>";
                                    echo "</td>";
                                } else {
                                    echo "<td style='background-color:#FFEBEE;'>";
                                    echo "<span class='status-pending'>Pending</span>";
                                    echo "</td>";
                                }
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>