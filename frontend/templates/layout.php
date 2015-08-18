<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$rss = filter_input(INPUT_GET, "rss");
if (!isset($rss)) {
    $p = new page();
    $p->_page();
    include 'frontend/templates/header.php';
    include(content);
    include 'frontend/templates/footer.php';
} else {
    $rss_creator = new Rss_Creator();
    $rss_creator->show_rss();
}
