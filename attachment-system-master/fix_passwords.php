<?php
// Fix 1: trainers/login.php - Revert password_verify to md5 to match registration
$file = 'trainers/login.php';
$content = file_get_contents($file);
$content = str_replace('password_verify($password, $logged_in_user[\'password\'])', 'md5($password) == $logged_in_user[\'password\']', $content);
file_put_contents($file, $content);
echo "Fixed trainers/login.php\n";

// Fix 2: trainers/includes/server.php - Revert password_verify to md5
$file = 'trainers/includes/server.php';
$content = file_get_contents($file);
$content = str_replace('password_verify($password, $logged_in_user[\'password\'])', 'md5($password) == $logged_in_user[\'password\']', $content);
file_put_contents($file, $content);
echo "Fixed trainers/includes/server.php\n";

// Fix 3: trainers/changepassword.php - Fix $conn issue
$file = 'trainers/changepassword.php';
$content = file_get_contents($file);
if (strpos($content, '$conn = $db;') === false) {
    $content = str_replace('include "includes/db.php";', 'include "includes/db.php";'."\n".'$conn = $db;', $content);
    file_put_contents($file, $content);
    echo "Fixed trainers/changepassword.php\n";
}

// Fix 4: students/changepassword.php - Add missing PHP logic
$file = 'students/changepassword.php';
$content = file_get_contents($file);
if (strpos($content, '<?php') === false) {
    $php_logic = "<?php\n" .
    "session_start();\n" .
    "include \"./includes/db.php\";\n" .
    "if (!isset(\$_SESSION['user'])) {\n" .
    "    \$_SESSION['msg'] = \"You must log in first\";\n" .
    "    header('location: studentlogin.php');\n" .
    "}\n" .
    "if (isset(\$_POST['change_pwd'])) {\n" .
    "    \$admissionnumber = \$_POST['admissionnumber'];\n" .
    "    \$cpassword = \$_POST['cpassword'];\n" .
    "    \$password = \$_POST['password'];\n" .
    "    \$re_password = \$_POST['re_password'];\n" .
    "    \$cpassword = md5(\$cpassword);\n" .
    "    \$stmt = \"SELECT * FROM students WHERE admission_number='\$admissionnumber' and password='\$cpassword'\";\n" .
    "    \$result = mysqli_query(\$conn, \$stmt);\n" .
    "    \$rows = mysqli_num_rows(\$result);\n" .
    "    if (\$rows !== 1) {\n" .
    "        echo \"<script>alert('Invalid admission number or current password')</script>\";\n" .
    "    } elseif (\$password == \$re_password) {\n" .
    "        \$password = md5(\$password);\n" .
    "        \$sql = \"UPDATE students SET password='\$password' WHERE admission_number='\$admissionnumber' \";\n" .
    "        \$query = mysqli_query(\$conn, \$sql);\n" .
    "        if (\$query) {\n" .
    "            session_destroy();\n" .
    "            echo \"<script>alert('Password updated successfully. Please login again.');window.location = 'studentlogin.php'</script>\";\n" .
    "        } else {\n" .
    "            echo \"<script>alert('Failed to Update password');window.location = 'changepassword.php'</script>\";\n" .
    "        }\n" .
    "    } else {\n" .
    "        echo \"<script>alert('The two passwords do not match');window.location = 'changepassword.php'</script>\";\n" .
    "    }\n" .
    "}\n" .
    "?>\n";
    $content = $php_logic . $content;
    file_put_contents($file, $content);
    echo "Fixed students/changepassword.php\n";
}

// Fix 5: lecturers/changepassword.php - Add session_destroy to ensure clean logout after password change
$file = 'lecturers/changepassword.php';
$content = file_get_contents($file);
if (strpos($content, 'session_destroy();') === false) {
    $content = str_replace('echo "<script>alert(\'Password updated successfully\');window.location = \'lecturerlogin.php\'</script>";', 
                           "session_destroy();\n            echo \"<script>alert('Password updated successfully. Please login again.');window.location = 'lecturerlogin.php'</script>\";", 
                           $content);
    file_put_contents($file, $content);
    echo "Fixed lecturers/changepassword.php\n";
}
?>
