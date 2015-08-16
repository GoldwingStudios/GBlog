<!--/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */-->
<div class="start">
    <div class="navigation">
        <?php
        include ("modules/UI/navigation/navigation.php");
        ?>
    </div>
    <div class="content_layout">
        <div class="page_content_">
            <?php
            if (!USER_LOGGED_IN && !USER_LOGIN_ERROR) {
                include("modules/UI/login/login_form.php");
            } else if (USER_LOGGED_IN && !isset($_GET["logout"])) {
                include './modules/admin_functions/Admin_Functions.php';
            } else if (USER_LOGGED_IN && isset($_GET["logout"])) {
                $Logout_Module = new Logout();
                $Logout_Module->Run();
            } else if (USER_LOGIN_ERROR) {
                $Logout_Module = new Logout();
                $Logout_Module->Run();
            }
            ?>
        </div>
    </div>
</div>