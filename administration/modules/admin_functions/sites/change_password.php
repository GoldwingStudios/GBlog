<?php
/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$chng = filter_input(INPUT_POST, "change_password");
if (isset($chng) && $chng == 1 && $_SESSION["Logged_In"]) {
    $Change_Password = new Change_Password();
    $result = $Change_Password->Set_New_Password();
}
?>
<div class="start">
    <div class="navigation">
        <?php
        include ("modules/UI/navigation/navigation.php");
        ?>
    </div>
    <div class="start_content">
        <?php
        if ($_SESSION["Logged_In"]) {
            ?>
            <div class="content_layout">
                <?php
                if (!isset($result)) {
                    ?>
                    <div class="page_title">
                        <span class="page_title"><?php echo ucwords(strtolower($_SESSION["current_page"])); ?></span><br/>
                        <span class="page_description">Hier k&ouml;nnen Sie ihr bestehendes Passwort &auml;ndern!</span>
                    </div>
                    <div class="page_content">
                        <div class="pw_changer_container">
                            <form method="POST" action="?sm=cp">
                                <input type="text" style="display: none;" name="change_password" value="1" />
                                <input type="text" style="display: none;" name="current_user" value="<?php echo $_SESSION["User"] ?>" />
                                <div class="pw_changer">
                                    Aktuelles Passwort: <input class="pw_input" name="old_pass" type="password" />
                                </div>
                                <div class="pw_changer">
                                    Neues Passwort: <input class="pw_input" name="new_pass" type="password" />
                                </div>
                                <div class="pw_changer">
                                    Neues Passwort best&auml;tigen: <input class="pw_input" name="new_pass_confirmation" type="password" />
                                </div>
                                <div class="pw_changer">
                                    <input class="pw_submit" type="submit" value="Passwort &auml;ndern!"/>
                                </div>
                            </form>

                        </div>
                    </div>
                    <?php
                } else if ($result == 0) {
                    ?>
                    <div class="page_title">
                        <span class="page_title"><?php echo ucwords(strtolower($_SESSION["current_page"])); ?></span><br/>
                        <span class="page_description">Hier k&ouml;nnen Sie ihr bestehendes Passwort &auml;ndern!</span>
                    </div>
                    <div class="page_content">
                        <div class="pw_changer_container">
                            <form method="POST" action="?sm=cp">
                                <input type="text" style="display: none;" name="change_password" value="1" />
                                <div class="pw_changer">
                                    Aktuelles Passwort: <input class="pw_input" name="old_pass" type="password" />
                                </div>
                                <div class="pw_changer">
                                    Neues Passwort: <input class="pw_input" name="new_pass" type="password" />
                                </div>
                                <div class="pw_changer">
                                    Neues Passwort best&auml;tigen: <input class="pw_input" name="new_pass_confirmation" type="password" />
                                </div>
                                <div class="pw_changer">
                                    <input class="pw_submit" type="submit" value="Passwort &auml;ndern!"/>
                                </div>
                            </form>

                        </div>
                    </div>
                    <?php
                } else if ($result == 1) {
                    ?>
                    <div class="page_title">
                        <span class="page_title"><?php echo ucwords(strtolower($_SESSION["current_page"])); ?></span><br/>
                        <span class="page_description">Hier k&ouml;nnen Sie ihr bestehendes Passwort &auml;ndern!</span>
                    </div>
                    <div class="page_content">
                        <div class="pw_changer_container">
                            <b>Passwort erfolgreich ge&auml;ndert!</b><br><br>
                            <a href="index.php">Zur&uuml;ck</a>
                        </div>
                    </div>
                    <?php
                } else if ($result == 2) {
                    ?>
                    <div class="page_title">
                        <span class="page_title"><?php echo ucwords(strtolower($_SESSION["current_page"])); ?></span><br/>
                        <span class="page_description">Hier k&ouml;nnen Sie ihr bestehendes Passwort &auml;ndern!</span>
                    </div>
                    <div class="page_content">
                        <div class="pw_changer_container">
                            <form method="POST" action="?sm=cp">
                                <b>Das eingegebene Passwort stimmt mit dem aktuellen Passwort &uuml;berein!</b>
                            </form>
                            <div class="change_password_retry" onclick='window.location.href = "index.php?sm=cp"'>
                                <div class="change_password_retry_text">Erneut eingeben!</div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        } else if (($_SESSION["Logged_In"] && isset($_GET["logout"])) || (!$_SESSION["Logged_In"] && isset($_GET["logout"]))) {
            $Logout_Module = new Logout();
            $Logout_Module->Run();
        } else {
            echo "<script>window.location.replace('./index.php');</script>";
        }
        ?>
    </div>
</div>