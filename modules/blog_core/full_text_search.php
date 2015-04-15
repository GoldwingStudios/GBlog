/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php

include '../../backend/sql_connect.php';
include './post_search.php';

$search_tag = $_POST["search_tag"];

if (isset($search_tag)) {
    $post_search = new Post_Search();
    $x = $post_search->search_for_posts($search_tag);
    echo json_encode($x);
}