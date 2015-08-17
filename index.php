<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'backend/classloader.php';
include 'backend/sql_table_creator.php';
include 'backend/constants.php';
$view = new views();
$view->get_details($_SERVER);
include 'frontend/templates/layout.php';
?>