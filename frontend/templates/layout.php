<?php

$rss = filter_input(INPUT_GET, "rss");
if (!isset($rss)) {
    $p = new page();
    $p->_page();
    include 'frontend/templates/header.php';
    echo '<div class="container">';
    include(content);
    echo '</div>';
    include 'frontend/templates/footer.php';
} else {
    $rss_creator = new Rss_Creator();
    $rss_creator->show_rss();
}
