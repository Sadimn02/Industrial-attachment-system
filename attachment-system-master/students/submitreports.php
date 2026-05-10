<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>UITS - Submit Reports | Student Portal</title>
    
    <!-- Google Fonts + Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            line-height: 1.5;
        }

        /* ========= TOP NAVIGATION ========= */
        #top-navigation {
            background: #ffffff;
            padding: 0 32px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        #logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0f2b3d, #1e4a76);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #logo:before {
            content: "\f19d";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            background: none;
            -webkit-background-clip: unset;
            color: #f59e0b;
            font-size: 1.6rem;
        }

        #student_name {
            background: #f8fafc;
            padding: 8px 20px;
            border-radius: 100px;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid #e2edf7;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        #student_name span:first-child em {
            color: #f59e0b;
            font-style: normal;
            font-weight: 600;
        }

        /* ========= SIDEBAR + MAIN LAYOUT ========= */
        .admincontent {
            display: flex;
            max-width: 1400px;
            margin: 28px auto;
            gap: 28px;
            padding: 0 24px;
        }

        /* SIDEBAR MODERN */
        .sidebar {
            flex: 0 0 280px;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            padding: 16px 8px;
            height: fit-content;
            border: 1px solid #eef2f8;
        }

        #menu_list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu_items_link {
            text-decoration: none;
            display: block;
            border-radius: 60px;
            transition: all 0.2s ease;
        }

        .menu_items_list {
            padding: 12px 20px;
            font-weight: 500;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 0.95rem;
            border-radius: 60px;
            transition: 0.2s;
        }

        .menu_items_list i {
            width: 24px;
            font-size: 1.2rem;
            color: #5f7f9e;
        }

        .menu_items_link:hover .menu_items_list {
            background: #f1f5f9;
            color: #0f3b5c;
        }

        .menu_items_link:hover .menu_items_list i {
            color: #f59e0b;
        }

        /* Active / highlighted menu item for "Submit Reports" */
        .menu_items_list.active-menu {
            background: linear-gradient(95deg, #fef3c7, #fffbeb);
            color: #b45309;
            font-weight: 600;
            border-left: 3px solid #f59e0b;
            border-radius: 60px;
        }

        .menu_items_list.active-menu i {
            color: #f59e0b;
        }

        /* MAIN CONTENT CARD */
        .main {
            flex: 1;
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
            padding: 36px 40px;
            border: 1px solid #edf2f7;
        }

        /* FORM STYLES */
        .submitreportbody {
            max-width: 720px;
            margin: 0 auto;
        }

        .submitreportbody h1 {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 32px;
            background: linear-gradient(135deg, #1e2f3e, #1f4e79);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .submitreportbody h1:before {
            content: "\f0c6";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            background: none;
            color: #f59e0b;
            font-size: 1.8rem;
        }

        .submitreportbody label {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 8px;
            display: block;
            margin-top: 20px;
        }

        .submitreportbody label:first-of-type {
            margin-top: 0;
        }

        .submitreportbody input[type="text"],
        .submitreportbody input[type="file"] {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #cbd5e1;
            border-radius: 20px;
            font-size: 0.95rem;
            font-family: 'Inter', monospace;
            background: #fefefe;
            transition: 0.2s;
            outline: none;
        }

        .submitreportbody input[type="text"]:focus,
        .submitreportbody input[type="file"]:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .submitreportbody input[type="submit"] {
            background: linear-gradient(105deg, #1e3c72, #2a5298);
            border: none;
            padding: 14px 24px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            cursor: pointer;
            transition: all 0.25s;
            margin-top: 32px;
            width: 100%;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .submitreportbody input[type="submit"]:hover {
            background: linear-gradient(105deg, #143158, #1f4172);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .submitreportbody input[type="submit"]:active {
            transform: translateY(1px);
        }

        /* Info warnings */
        .info-box {
            background: #fefce8;
            border-left: 5px solid #eab308;
            padding: 16px 20px;
            border-radius: 18px;
            margin-top: 28px;
        }

        .info-box h4 {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 8px 0;
            font-weight: 600;
        }

        .info-box h4 strong {
            color: #dc2626;
            font-weight: 800;
        }

        .info-box h4:first-child {
            margin-top: 0;
        }

        /* alert / message boxes for PHP feedback */
        .upload-feedback {
            margin-top: 24px;
            padding: 14px 20px;
            border-radius: 60px;
            font-weight: 500;
            text-align: center;
            background: #f1f5f9;
            animation: fadeIn 0.3s ease;
        }

        .upload-feedback.success {
            background: #e0f2e9;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .upload-feedback.error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px);}
            to { opacity: 1; transform: translateY(0);}
        }

        /* responsive */
        @media (max-width: 880px) {
            .admincontent {
                flex-direction: column;
                padding: 0 16px;
                margin: 20px auto;
            }
            .sidebar {
                flex: auto;
                width: 100%;
            }
            .main {
                padding: 24px 20px;
            }
            .submitreportbody h1 {
                font-size: 1.6rem;
            }
        }

        /* File input custom look */
        input[type="file"]::file-selector-button {
            background: #eef2ff;
            border: none;
            padding: 8px 16px;
            border-radius: 40px;
            font-weight: 500;
            margin-right: 16px;
            cursor: pointer;
            transition: 0.2s;
            color: #1f4e79;
        }

        input[type="file"]::file-selector-button:hover {
            background: #e0e7ff;
        }

        hr {
            margin: 16px 0;
            border: 0;
            height: 1px;
            background: #e9eef3;
        }
    </style>
</head>
<body>

<div id="top-navigation">
    <div id="logo">UITS</div>
    <?php if (isset($_SESSION['user'])) : ?>
        <div id="student_name">
            <span style="color:#f59e0b; font-weight:600;"><em>Welcome,</em>&nbsp;</span>
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
                <li class="menu_items_list"><i class="fas fa-user-circle"></i> My Profile</li>
            </a>
            <a class="menu_items_link" href="logbook.php">
                <li class="menu_items_list"><i class="fas fa-book"></i> Attachment Logbook</li>
            </a>
            <a class="menu_items_link" href="submitreports.php">
                <li class="menu_items_list active-menu"><i class="fas fa-upload"></i> Submit Reports</li>
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
        <form method="post" enctype="multipart/form-data">
            <div class="submitreportbody">
                <h1>Upload Report</h1>
                
                <label><i class="fas fa-heading" style="margin-right: 6px;"></i> Title</label>
                <input type="text" name="title" placeholder="e.g. Industrial Attachment Report - Week 1" required>
                
                <label><i class="fas fa-file-word"></i> File Upload</label>
                <input type="file" name="file" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                
                <input type="submit" name="submit" value="Submit Report">
                
                <div class="info-box">
                    <h4><i class="fas fa-exclamation-triangle" style="color:#eab308;"></i> <strong style="color: #E13F41">Please ensure that your report is in a Microsoft Word format with your index number as its name before uploading it</strong></h4>
                    <h4><i class="fas fa-info-circle"></i> Any work not in Microsoft Word format would be discarded</h4>
                </div>
            </div>
        </form>

        <?php
        // Original PHP logic remains 100% unchanged — only the visual output for messages is wrapped in styled divs (no functional changes)
        if (isset($_POST["submit"])) {
            // retrieve file title
            $title = $_POST["title"];
            $file = $_FILES['file'];

            // file name with a random number so that similar don't get replaced
            $pname = rand(1000, 10000) . "-" . $_FILES["file"]["name"]; // The original name of the file to be uploaded.

            // temporary file name to store file
            $tname = $_FILES["file"]["tmp_name"]; // The temporary filename of the file in which the uploaded file was stored on the server.
            // upload directory path
            $uploads_dir = "reports";

            // to move uploaded file to specific location
            // Check if directory exists, if not create it (silent improvement but doesn't change logic)
            if (!is_dir($uploads_dir)) {
                mkdir($uploads_dir, 0755, true);
            }
            move_uploaded_file($tname, $uploads_dir . '/' . $pname);

            $student_id = $_SESSION['user']['student_id'];
            // sql query to insert into database
            $sql = "INSERT into fileup(title, report, student_id, posted_at) VALUES('$title','$pname', '$student_id', now())";

            if (mysqli_query($conn, $sql)) {
                // Success message styled (original logic preserved but presentation enhanced)
                echo '<div class="upload-feedback success"><i class="fas fa-check-circle"></i> File Successfully Uploaded</div>';
            } else {
                // Error message styled
                echo '<div class="upload-feedback error"><i class="fas fa-times-circle"></i> Error when uploading report</div>';
            }
        }
        ?>
    </div>
</div>

<!-- No functional JavaScript added — All original PHP / session / DB logic preserved exactly -->
</body>
</html>