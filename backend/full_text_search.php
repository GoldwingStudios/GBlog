<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
include '../administration/database_config.php';
include 'classes/DB_Connect.php';
include 'classes/post_search.php';

$search_tag = $_POST["search_tag"];

if (isset($search_tag)) {
    $post_search = new Post_Search();
    $x = $post_search->search_for_posts($search_tag);
    echo json_encode($x);
}