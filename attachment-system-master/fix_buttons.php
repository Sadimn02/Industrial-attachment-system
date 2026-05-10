<?php
$files = array_merge(
    glob('admin/*.php'),
    glob('admin/add/*.php'),
    glob('admin/update/*.php')
);

foreach($files as $file) {
    $content = file_get_contents($file);
    // Fix <button><a href="...">...</a></button>
    $new_content = preg_replace('/<button[^>]*>\s*<a href="([^"]*)">([^<]*)<\/a>\s*<\/button>/i', '<a href="$1" class="btn" style="display: inline-block; text-align: center; padding: 10px 20px; background: orange; color: white; text-decoration: none; border-radius: 5px;">$2</a>', $content);
    
    if($content !== $new_content) {
        file_put_contents($file, $new_content);
        echo "Updated buttons in $file\n";
    }
}
?>
