<?php
session_start();
//no one can access this page apart from the students /(security)
if ($_SESSION['utype'] == 'student') {
} else {
    echo "<script>alert('You must login first')</script>";
    echo "<script>location.href='studentlogin.php'</script>";
}
include "logbook_functions.php";

if (!isset($_SESSION['user'])) {
    echo "<script>alert('You must login first')</script>";
    header('location: studentlogin.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: studentlogin.php");
}
?>

<html>
<head>
    <title>UITS - Student Logbook System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts & Font Awesome for Icons -->
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
            background: #f0f4f8;
            color: #1e2a3e;
            line-height: 1.5;
        }

        /* TOP NAVIGATION (UI IMPROVED) */
        #top-navigation {
            background: linear-gradient(135deg, #0b2b3b 0%, #1c4e6f 100%);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        #logo {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            background: linear-gradient(120deg, #FFE6B0, #FFB347);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        #student_name {
            background: rgba(255,255,255,0.12);
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            backdrop-filter: blur(2px);
            font-size: 0.95rem;
            color: white;
        }

        /* MAIN LAYOUT */
        .admincontent {
            display: flex;
            gap: 2rem;
            max-width: 1440px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* SIDEBAR MODERN */
        .sidebar {
            flex: 0 0 260px;
            background: white;
            border-radius: 28px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            height: fit-content;
            position: sticky;
            top: 90px;
        }

        #menu_list {
            list-style: none;
            padding: 0.75rem 0;
        }

        .menu_items_link {
            display: block;
            text-decoration: none;
            color: #1e2f3e;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .menu_items_list {
            padding: 0.9rem 1.8rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
            border-left: 3px solid transparent;
        }

        .menu_items_list i {
            width: 24px;
            font-size: 1.15rem;
            color: #5f7f9e;
        }

        .menu_items_link:hover .menu_items_list {
            background-color: #fef5e8;
            border-left-color: #FFA500;
        }

        .menu_items_link:nth-child(2) .menu_items_list {
            background-color: #fff0db;
            border-left-color: #FFA500;
            font-weight: 600;
        }

        /* MAIN PANEL */
        .main {
            flex: 1;
            min-width: 0;
        }

        /* FORM CARD (PRESERVING ORIGINAL STRUCTURE) */
        .logbook-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            padding: 1.8rem 2rem;
            margin-bottom: 2rem;
        }

        .inputgroup {
            margin-bottom: 1.5rem;
        }

        .inputgroup label {
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #5c6f87;
            display: block;
            margin-bottom: 0.5rem;
        }

        select.form-control {
            width: 100%;
            max-width: 320px;
            padding: 0.75rem 1rem;
            border-radius: 60px;
            border: 1px solid #d0dde9;
            background: #fefefe;
            font-family: 'Inter', monospace;
            font-size: 0.9rem;
            outline: none;
        }

        select.form-control:focus {
            border-color: #FFA500;
            box-shadow: 0 0 0 3px rgba(255,165,0,0.2);
        }

        /* BUTTON GROUP (same days, better style) */
        .btn-group-days {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 1.5rem 0 1rem;
        }

        .btn {
            background: #f1f5f9;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.8rem;
            color: #2c3e50;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn i {
            margin-right: 6px;
        }

        .btn:hover {
            background: #ffe0b5;
            transform: translateY(-2px);
        }

        /* preserve original class styles for textareas and inputs */
        .aside {
            width: 100%;
        }
        textarea {
            width: 90%;
            border-radius: 20px;
            border: 1px solid #cfdfed;
            padding: 1rem;
            font-family: 'Inter', monospace;
            font-size: 0.9rem;
            resize: vertical;
            background: #fefefe;
            margin-bottom: 12px;
        }
        textarea:focus {
            border-color: #ffb347;
            outline: none;
            box-shadow: 0 0 0 2px rgba(255,180,70,0.2);
        }

        .btn.sv2, .btn.sv3, .btn.sv4, .btn.sv5, .btn.sv6, .btn.sv7, .btn.sv8 {
            background-color: #FFA500;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 60px;
            font-weight: 600;
            margin-right: 8px;
            margin-top: 8px;
            color: #1e2f3e;
        }
        .btn.sv2:hover, .btn.sv3:hover, .btn.sv4:hover, .btn.sv5:hover, .btn.sv6:hover, .btn.sv7:hover, .btn.sv8:hover {
            background-color: #ff8c1a;
            transform: translateY(-1px);
        }

        hr {
            margin: 1rem 0;
            border-color: #e2edf7;
        }

        /* TABLE MODERN */
        .article {
            background: white;
            border-radius: 28px;
            overflow-x: auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            padding: 0.5rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
            min-width: 1000px;
        }
        .table th {
            background: #1e3a5f;
            color: white;
            padding: 12px 8px;
            font-weight: 600;
            font-size: 0.75rem;
            text-align: center;
            border: 1px solid #2d4a6e;
        }
        .table td {
            padding: 12px 8px;
            text-align: center;
            border: 1px solid #e0e9f2;
            vertical-align: middle;
        }

        @media (max-width: 800px) {
            .admincontent {
                flex-direction: column;
            }
            .sidebar {
                position: static;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php
    //selecting week from table weeks
    $db = mysqli_connect('localhost', 'root', '', 'dbsupervise');
    $query = "SELECT * FROM tbl_weeks";
    $select_all_weeks = mysqli_query($db, $query);
    ?>
    <div id="top-navigation">
        <div id="logo"><i class="fas fa-book"></i> UITS</div>
        <?php if (isset($_SESSION['user'])) : ?>
            <div id="student_name"><span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp;
                </span><span style="font-family:serif"><?php echo $_SESSION['user']['fullname']; ?></span></div>
        <?php endif ?>
    </div>

    <div class="admincontent">
        <div class="sidebar">
            <ul id="menu_list">
                <a class="menu_items_link" href="studentprofile.php">
                    <li class="menu_items_list"><i class="fas fa-user-circle"></i> My Profile</li>
                </a>
                <a class="menu_items_link" href="logbook.php">
                    <li class="menu_items_list"><i class="fas fa-calendar-week"></i> Attachment Logbook</li>
                </a>
                <a class="menu_items_link" href="submitreports.php">
                    <li class="menu_items_list"><i class="fas fa-file-alt"></i> Student Reports</li>
                </a>
                <a class="menu_items_link" href="changepassword.php">
                    <li class="menu_items_list"><i class="fas fa-key"></i> Change Password</li>
                </a>
                <a class="menu_items_link" href="logbook.php?logout">
                    <li class="menu_items_list"><i class="fas fa-sign-out-alt"></i> Logout</li>
                </a>
            </ul>
        </div>

        <div class="main">
            <form method="post" action="logbook.php">
                <div class="logbook-card">
                    <div class="nav" style="width: 100%;">
                        <div class="inputgroup">
                            <label for="weeks"><i class="fas fa-layer-group"></i> WEEKS</label>
                            <select class="form-control" name="week_id" id="weeks">
                                <option value="">--- Choose Week ---</option>
                                <?php foreach ($select_all_weeks as $row) : ?>
                                    <option value="<?php echo $row['week_id']; ?>"><?php echo $row['week_title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="btn-group-days">
                            <input type="button" value="MONDAY" name="mon_days" onclick="myFunction()" class="btn">
                            <input type="button" value="TUESDAY" name="tue_days" onclick="myFunction1()" class="btn">
                            <input type="button" value="WEDNESDAY" name="wed_days" onclick="myFunction2()" class="btn">
                            <input type="button" value="THURSDAY" name="thur_days" onclick="myFunction3()" class="btn">
                            <input type="button" value="FRIDAY" name="fri_days" onclick="myFunction4()" class="btn">
                            <input type="button" value="SATURDAY" name="sat_days" onclick="myFunction5()" class="btn">
                            <button onclick="myFunction6()" type="button" class="btn">WEEK REMARK</button>
                        </div>

                        <div class="aside" style="width: 100%;">
                            <hr>
                            <label for="inputEmail4" style="color:black; font-weight:600;">TODAY NOTES</label>
                            <!-- ALL ORIGINAL FIELDS WITH SAME IDS/CLASSES - INTACT -->
                            <input type="text" id="mon" name="mon_day" class="mon" value="MONDAY" placeholder="MONDAY" readonly />
                            <textarea type="text" id="bld" name="mon_notes" class="bld" placeholder="MONDAY NOTES"></textarea>
                            
                            <input type="text" id="tue" name="tue_day" class="tue" value="TUESDAY" placeholder="TUESDAY" readonly />
                            <textarea type="text" id="cole" name="tue_notes" class="cole" placeholder="TUESDAY NOTES"></textarea>
                            
                            <input type="text" id="wed" name="wed_day" class="tue" value="WEDNESDAY" placeholder="WEDNESDAY" readonly />
                            <textarea type="text" id="hrt" name="wed_notes" class="hrt" placeholder="WEDNESDAY NOTES"></textarea>
                            
                            <input type="text" id="thur" name="thur_day" class="thur" value="THURSDAY" placeholder="THURSDAY" readonly />
                            <textarea type="text" id="thal" name="thur_notes" class="thal" placeholder="THURSDAY NOTES"></textarea>
                            
                            <input type="text" id="fri" name="fri_day" class="fri" value="FRIDAY" placeholder="FRIDAY" readonly />
                            <textarea type="text" id="wt" name="fri_notes" class="wt" placeholder="FRIDAY NOTES"></textarea>
                            
                            <input type="text" id="sat" name="sat_day" class="sat" value="SATURDAY" placeholder="SATURDAY" readonly />
                            <textarea type="text" id="ht" name="sat_notes" class="ht" placeholder="SATURDAY NOTES"></textarea>
                            
                            <input type="text" id="remark" name="remark" class="remark" value="REMARK" placeholder="REMARK" readonly />
                            <textarea type="text" id="rmk" name="remarks_notes" class="rmk" placeholder="WEEKLY REMARK"></textarea>
                            
                            <!-- buttons: IDs preserved exactly -->
                            <input type="submit" name="create_post" id="btn_save1" value="MONDAY SUBMIT" class="btn sv2">
                            <input name="create_post1" type="submit" id="btn_save2" value="TUESDAY SUBMIT" class="btn sv3">
                            <input name="create_post2" type="submit" id="btn_save3" value="WEDNESDAY SUBMIT" class="btn sv4">
                            <input name="create_post3" type="submit" id="btn_save4" value="THURSDAY SUBMIT" class="btn sv5">
                            <input name="create_post4" type="submit" id="btn_save5" value="FRIDAY SUBMIT" class="btn sv6">
                            <input name="create_post5" type="submit" id="btn_save6" value="SATURDAY SUBMIT" class="btn sv7">
                            <input name="create_post6" type="submit" id="btn_save7" value="SUBMIT REMARK" class="btn sv8">
                            <hr>
                        </div>
                    </div>
                </div>
            </form>

            <div class="article">
                <table class="table table-striped" width="100%" id="mytable" border="2" style="background-color: #f4f9ff; margin: 0 auto;">
                    <thead>
                        <tr>
                            <th><b>week/12</b></th>
                            <th><b>MONDAY</b></th>
                            <th><b>TUESDAY</b></th>
                            <th><b>WEDNESDAY</b></th>
                            <th><b>THURSDAY</b></th>
                            <th><b>FRIDAY</b></th>
                            <th><b>SATURDAY</b></th>
                            <th><b>Student Comments</b></th>
                            <th><b>LECTURER REMARKS</b></th>
                            <th><b>TRAINER REMARKS</b></th>
                        </tr>
                    </thead>
                    <tbody id="show_data">
                        <?php
                        $student_id = $_SESSION['user']['student_id'];
                        foreach ($select_all_weeks as $key => $t) {
                            echo "<tr>";
                            echo "<td style='font-weight:700; background:#eef3fc;'>" . $t['week_title'] . "</td>";
                            $conn = mysqli_connect('localhost', 'root', '', 'dbsupervise');
                            $query12 = "SELECT * FROM logbookdata WHERE week_id='" . $t['week_id'] . "' AND student_id='" . $student_id . "' ";
                            $res = mysqli_query($conn, $query12);
                            $week_days = array('MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'REMARK', 'LEC_COMMENT', 'TRAINER_COMMENT');
                            $classes = array();
                            while ($row = mysqli_fetch_assoc($res)) {
                                $classes[$row['day_title']] = $row;
                            }
                            foreach ($week_days as $day) {
                                if (array_key_exists($day, $classes)) {
                                    $row = $classes[$day];
                                    echo "<td style='background-color:#e2f3e4; color:#1f5420;'>" . nl2br(htmlspecialchars($row['day_notes'])) . "<br><small style='opacity:0.7'>" . $row['created_at'] . "</small></td>";
                                } else {
                                    echo "<td style='background-color:#ffe6e5; color:#a1221a;'>Pending</td>";
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

    <!-- JAVASCRIPT FUNCTIONS - COMPLETELY UNCHANGED, EXACT COPY FROM ORIGINAL -->
    <script>
        //monday input
        function myFunction() {
            var x = document.getElementById("bld");
            var z = document.getElementById("hrt");
            var y = document.getElementById("cole");
            var a = document.getElementById("thal");
            var b = document.getElementById("wt");
            var c = document.getElementById("ht");
            var d = document.getElementById("rmk");
            var e = document.getElementById("mon");
            var f = document.getElementById("tue");
            var g = document.getElementById("wed");
            var h = document.getElementById("thur");
            var i = document.getElementById("fri");
            var j = document.getElementById("sat");
            var k = document.getElementById("remark");
            var sv2 = document.getElementById("btn_save1");
            var sv3 = document.getElementById("btn_save2");
            var sv4 = document.getElementById("btn_save3");
            var sv5 = document.getElementById("btn_save4");
            var sv6 = document.getElementById("btn_save5");
            var sv7 = document.getElementById("btn_save6");
            var sv8 = document.getElementById("btn_save7");
            if (x.style.display === "none") {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                f.style.display = "none";
                g.style.display = "none";
                x.style.display = "block";
                y.style.display = "none";
                e.style.display = "block";
                z.style.display = "none";
                a.style.display = "none";
                sv2.style.display = "block";
                b.style.display = "none";
                d.style.display = "none";
                sv6.style.display = "none";
                c.style.display = "none";
                sv7.style.display = "none";
                sv3.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "none";
                sv8.style.display = "none";
            } else {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                x.style.display = "none";
                e.style.display = "none";
                a.style.display = "none";
                sv2.style.display = "none";
                y.style.display = "none";
                z.style.display = "none";
                b.style.display = "none";
                c.style.display = "none";
                sv7.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
                sv6.style.display = "none";
                sv3.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "none";
            }
        }
        //tuesday input
        function myFunction1() {
            var h = document.getElementById("thur");
            var i = document.getElementById("fri");
            var j = document.getElementById("sat");
            var k = document.getElementById("remark");
            var g = document.getElementById("wed");
            var f = document.getElementById("tue");
            var d = document.getElementById("rmk");
            var a = document.getElementById("thal");
            var x = document.getElementById("cole");
            var y = document.getElementById("bld");
            var z = document.getElementById("hrt");
            var b = document.getElementById("wt");
            var c = document.getElementById("ht");
            var e = document.getElementById("mon");
            var sv2 = document.getElementById("btn_save1");
            var sv3 = document.getElementById("btn_save2");
            var sv4 = document.getElementById("btn_save3");
            var sv5 = document.getElementById("btn_save4");
            var sv6 = document.getElementById("btn_save5");
            var sv7 = document.getElementById("btn_save6");
            var sv8 = document.getElementById("btn_save7");
            if (x.style.display === "none") {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "block";
                x.style.display = "block";
                y.style.display = "none";
                e.style.display = "none";
                z.style.display = "none";
                a.style.display = "none";
                b.style.display = "none";
                sv4.style.display = "none";
                c.style.display = "none";
                sv7.style.display = "none";
                sv3.style.display = "block";
                sv2.style.display = "none";
                sv5.style.display = "none";
                sv6.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
            } else {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                e.style.display = "none";
                x.style.display = "none";
                y.style.display = "none";
                a.style.display = "none";
                b.style.display = "none";
                z.style.display = "none";
                c.style.display = "none";
                sv7.style.display = "none";
                sv4.style.display = "none";
                sv3.style.display = "none";
                sv2.style.display = "none";
                sv5.style.display = "none";
                sv6.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
            }
        }
        // wednesday input
        function myFunction2() {
            var h = document.getElementById("thur");
            var i = document.getElementById("fri");
            var j = document.getElementById("sat");
            var k = document.getElementById("remark");
            var g = document.getElementById("wed");
            var f = document.getElementById("tue");
            var d = document.getElementById("rmk");
            var a = document.getElementById("thal");
            var x = document.getElementById("hrt");
            var y = document.getElementById("bld");
            var z = document.getElementById("cole");
            var b = document.getElementById("wt");
            var c = document.getElementById("ht");
            var e = document.getElementById("mon");
            var sv4 = document.getElementById("btn_save3")
            var sv2 = document.getElementById("btn_save1");
            var sv3 = document.getElementById("btn_save2");
            var sv5 = document.getElementById("btn_save4");
            var sv6 = document.getElementById("btn_save5");
            var sv7 = document.getElementById("btn_save6");
            var sv8 = document.getElementById("btn_save7");
            if (x.style.display === "none") {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "block";
                f.style.display = "none";
                x.style.display = "block";
                sv4.style.display = "block";
                z.style.display = "none";
                e.style.display = "none";
                sv2.style.display = "none";
                y.style.display = "none";
                sv3.style.display = "none";
                sv5.style.display = "none";
                a.style.display = "none";
                b.style.display = "none";
                sv6.style.display = "none";
                c.style.display = "none";
                sv7.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
            } else {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                x.style.display = "none";
                sv4.style.display = "none";
                y.style.display = "none";
                e.style.display = "none";
                sv2.style.display = "none";
                z.style.display = "none";
                sv3.style.display = "none";
                a.style.display = "none";
                sv5.style.display = "none";
                b.style.display = "none";
                sv6.style.display = "none";
                c.style.display = "none";
                sv7.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
            }
        }
        // thursday input
        function myFunction3() {
            var h = document.getElementById("thur");
            var i = document.getElementById("fri");
            var j = document.getElementById("sat");
            var k = document.getElementById("remark");
            var g = document.getElementById("wed");
            var f = document.getElementById("tue");
            var d = document.getElementById("rmk");
            var e = document.getElementById("mon");
            var x = document.getElementById("thal");
            var sv5 = document.getElementById("btn_save4");
            var a = document.getElementById("hrt");
            var y = document.getElementById("bld");
            var z = document.getElementById("cole");
            var b = document.getElementById("wt");
            var c = document.getElementById("ht");
            var sv4 = document.getElementById("btn_save3")
            var sv2 = document.getElementById("btn_save1");
            var sv3 = document.getElementById("btn_save2");
            var sv6 = document.getElementById("btn_save5");
            var sv7 = document.getElementById("btn_save6");
            var sv8 = document.getElementById("btn_save7");
            if (x.style.display === "none") {
                h.style.display = "block";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                x.style.display = "block";
                y.style.display = "none";
                e.style.display = "none";
                z.style.display = "none";
                a.style.display = "none";
                sv3.style.display = "none";
                b.style.display = "none";
                sv6.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "block";
                sv2.style.display = "none";
                sv6.style.display = "none";
                sv7.style.display = "none";
                c.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
            } else {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                e.style.display = "none";
                x.style.display = "none";
                y.style.display = "none";
                z.style.display = "none";
                a.style.display = "none";
                b.style.display = "none";
                sv3.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "none";
                sv2.style.display = "none";
                sv6.style.display = "none";
                sv7.style.display = "none";
                c.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
            }
        }
        //friday input
        function myFunction4() {
            var h = document.getElementById("thur");
            var i = document.getElementById("fri");
            var j = document.getElementById("sat");
            var k = document.getElementById("remark");
            var g = document.getElementById("wed");
            var f = document.getElementById("tue");
            var e = document.getElementById("mon");
            var d = document.getElementById("rmk");
            var x = document.getElementById("wt");
            var y = document.getElementById("bld");
            var z = document.getElementById("hrt");
            var a = document.getElementById("cole");
            var b = document.getElementById("thal");
            var c = document.getElementById("ht");
            var sv2 = document.getElementById("btn_save1");
            var sv3 = document.getElementById("btn_save2");
            var sv4 = document.getElementById("btn_save3");
            var sv5 = document.getElementById("btn_save4");
            var sv6 = document.getElementById("btn_save5");
            var sv7 = document.getElementById("btn_save6");
            var sv8 = document.getElementById("btn_save7");
            if (x.style.display === "none") {
                h.style.display = "none";
                i.style.display = "block";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                x.style.display = "block";
                y.style.display = "none";
                e.style.display = "none";
                z.style.display = "none";
                a.style.display = "none";
                b.style.display = "none";
                c.style.display = "none";
                sv3.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "none";
                sv6.style.display = "block";
                sv2.style.display = "none";

                sv7.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
            } else {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                x.style.display = "none";
                y.style.display = "none";
                z.style.display = "none";
                e.style.display = "none";
                a.style.display = "none";
                b.style.display = "none";
                c.style.display = "none";
                sv3.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "none";
                sv6.style.display = "none";
                sv2.style.display = "none";
                sv7.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
            }
        }
        // saturday input
        function myFunction5() {
            var h = document.getElementById("thur");
            var i = document.getElementById("fri");
            var j = document.getElementById("sat");
            var k = document.getElementById("remark");
            var g = document.getElementById("wed");
            var f = document.getElementById("tue");
            var d = document.getElementById("rmk");
            var e = document.getElementById("mon");
            var x = document.getElementById("ht");
            var y = document.getElementById("bld");
            var z = document.getElementById("hrt");
            var a = document.getElementById("cole");
            var b = document.getElementById("thal");
            var c = document.getElementById("wt");
            var sv2 = document.getElementById("btn_save1");
            var sv3 = document.getElementById("btn_save2");
            var sv4 = document.getElementById("btn_save3");
            var sv5 = document.getElementById("btn_save4");
            var sv6 = document.getElementById("btn_save5");
            var sv7 = document.getElementById("btn_save6");
            var sv8 = document.getElementById("btn_save7");
            if (x.style.display === "none") {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "block";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                x.style.display = "block";
                y.style.display = "none";
                e.style.display = "none";
                z.style.display = "none";
                a.style.display = "none";
                b.style.display = "none";
                c.style.display = "none";
                sv3.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "none";
                sv6.style.display = "none";
                sv7.style.display = "block";
                sv2.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";
            } else {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                x.style.display = "none";
                y.style.display = "none";
                z.style.display = "none";
                e.style.display = "none";
                a.style.display = "none";
                b.style.display = "none";
                c.style.display = "none";
                sv3.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "none";
                sv6.style.display = "none";
                sv7.style.display = "none";
                sv2.style.display = "none";
                d.style.display = "none";
                sv8.style.display = "none";

            }
        }
        //students' comments input
        function myFunction6() {
            var h = document.getElementById("thur");
            var i = document.getElementById("fri");
            var j = document.getElementById("sat");
            var k = document.getElementById("remark");
            var g = document.getElementById("wed");
            var f = document.getElementById("tue");
            var r = document.getElementById("rmk");
            var x = document.getElementById("bld");
            var z = document.getElementById("hrt");
            var y = document.getElementById("cole");
            var a = document.getElementById("thal");
            var b = document.getElementById("wt");
            var c = document.getElementById("ht");
            var e = document.getElementById("mon");
            var sv2 = document.getElementById("btn_save1");
            var sv3 = document.getElementById("btn_save2");
            var sv4 = document.getElementById("btn_save3");
            var sv5 = document.getElementById("btn_save4");
            var sv6 = document.getElementById("btn_save5");
            var sv7 = document.getElementById("btn_save6");
            var sv8 = document.getElementById("btn_save7");
            if (r.style.display === "none") {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "block";
                g.style.display = "none";
                f.style.display = "none";
                r.style.display = "block";
                e.style.display = "none";
                x.style.display = "none";
                y.style.display = "none";
                z.style.display = "none";
                a.style.display = "none";
                sv2.style.display = "none";
                b.style.display = "none";
                sv6.style.display = "none";
                c.style.display = "none";
                sv7.style.display = "none";
                sv3.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "none";
                sv8.style.display = "block";
            } else {
                h.style.display = "none";
                i.style.display = "none";
                j.style.display = "none";
                k.style.display = "none";
                g.style.display = "none";
                f.style.display = "none";
                e.style.display = "none";
                r.style.display = "none";
                x.style.display = "none";
                a.style.display = "none";
                sv2.style.display = "none";
                y.style.display = "none";
                z.style.display = "none";
                b.style.display = "none";
                c.style.display = "none";
                sv7.style.display = "none";
                sv8.style.display = "none";
                sv6.style.display = "none";
                sv3.style.display = "none";
                sv4.style.display = "none";
                sv5.style.display = "none";
            }
        }
    </script>
</body>
</html>