<?php
$dirs = [
    'admin' => 'dashboard.php?logout', 
    'lecturers' => 'assigned.php?logout', 
    'students' => 'logbook.php?logout', 
    'trainers' => 'assignedtrainer.php?logout'
]; 
foreach($dirs as $dir => $target) { 
    $files = glob($dir . '/*.php'); 
    foreach($files as $file) { 
        $content = file_get_contents($file); 
        $new_content = preg_replace('/href="[^"]*?logout[^"]*"/i', 'href="' . $target . '"', $content); 
        if($content !== $new_content) { 
            file_put_contents($file, $new_content); 
            echo "Updated $file\n"; 
        } 
    } 
}
?>
