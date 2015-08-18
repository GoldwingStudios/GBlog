<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (file_exists("database_config.php")) {
    include './database_config.php';
    include 'backend/classloader.php';
    include 'backend/session_management.php';
    include 'backend/constants.php';
    include 'frontend/templates/layout.php';
} else {
    header('Location: ./installer.php');
    exit;
}
?>