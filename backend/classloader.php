<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$path = "backend/classes/*.php";
$classes = glob($path);

foreach ($classes as $class) {
    include $class;
}

include 'modules/Comments/backend/Get_Comments.php';
include 'modules/Comments/backend/Save_Comment_Request.php';
include 'modules/rss/rss_creator.php';
