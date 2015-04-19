<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$p = new Page();
$p->_Page();
include 'frontend/templates/header.php';
echo '<div class="container">';
include($content);
echo '</div>';
include 'frontend/templates/footer.php';
?>