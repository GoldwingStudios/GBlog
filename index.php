<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

include 'backend/classloader.php';
include 'backend/sql_table_creator.php';
include 'backend/constants.php';

include 'frontend/templates/layout.php';

?>