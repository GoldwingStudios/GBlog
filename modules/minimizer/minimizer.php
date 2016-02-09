<?php

$path = "modules\js\*.js";

$files = glob($path);

foreach ($files as $file) {
    $x = realpath($file);
    $content = file_get_contents($x);
    $clean_content = str_replace("\r", "", $content);
    $clean_content = str_replace("\n", "", $clean_content);
    echo "<script>" . $clean_content . "</script>";
}
?>