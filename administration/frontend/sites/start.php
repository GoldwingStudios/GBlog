/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<div class="image_container">
    <a href="http://www.goldwingstudios.de" target="_blank">
        <img class="gws_banner" src="assets/images/fgws.png"/>
    </a>
</div>
<?php
//$content
?>
<div class="start">
    <div class="navigation">
        <?php
        include ("modules/UI/navigation/navigation.php");
        ?>
    </div>
    <div class="content_layout">
        <div class="page_content_">
            <?php
            if (!$_SESSION["Logged_In"] && !$_SESSION["Login_Error"]) {
                include("modules/UI/login/login_form.php");
            } else if ($_SESSION["Logged_In"] && !isset($_GET["logout"])) {
                include './modules/admin_functions/Admin_Functions.php';
            } else if ($_SESSION["Logged_In"] && isset($_GET["logout"])) {
                $Logout_Module = new Logout();
                $Logout_Module->Run();
            } else if ($_SESSION["Login_Error"]) {
                $Logout_Module = new Logout();
                $Logout_Module->Run();
            }
            ?>
        </div>
    </div>
</div>