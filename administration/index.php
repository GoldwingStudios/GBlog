<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

include 'backend/classloader.php';
include 'backend/session_management.php';

include 'backend/constants.php';
include 'frontend/templates/layout.php';
?>