<?php
/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
if ($_SESSION["Logged_In"]) {
    ?>
    <div class="site_name">
        <span class="site_name_text">Sie sind gerade hier: <?php echo ucwords(strtolower($_SESSION["current_page"])); ?></span>
    </div>
    <div class="special_functions">
        <div class="home">
            <a href="index.php">
                <span><b>Home</b></span>
            </a>
        </div>
        <div class="logout">
            <a href="index.php?logout">
                <span><b>Logout</b></span>
            </a>
        </div>
    </div>
    <?php
}
?>