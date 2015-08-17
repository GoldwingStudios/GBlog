<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
include 'backend/classes/DB_Connect.php';
include 'backend/classes/post_search.php';

$search_tag = $_POST["search_tag"];

if (isset($search_tag)) {
    $post_search = new Post_Search();
    $x = $post_search->search_for_posts($search_tag);
    echo json_encode($x);
}