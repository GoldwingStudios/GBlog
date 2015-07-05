<?php
/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$return = null;
$mode = filter_input(INPUT_POST, "mode");
if (isset($mode) && $mode == 1 && $_SESSION["Logged_In"]) {
    $title = filter_input(INPUT_POST, "title");
    $text = $_POST["text"];
    $tags = filter_input(INPUT_POST, "tags");
    if (isset($title) && isset($text)) {
        $writer = new Write_Post();
        $return = $writer->Write_Post_($title, $text, $tags);
    }
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
                <div class="page_title">
                    <span class="page_title"><?php echo ucwords(strtolower($_SESSION["current_page"])); ?></span><br/>
                    <span class="page_description">Hier k&ouml;nnen Sie einen neuen Post schreiben und hinzuf&uuml;gen!</span>
                </div>
                <?php
                if (!isset($return) && !$return) {
                    ?>
                    <div class="page_content">
                        <form method="post" action="index.php?sm=wnp" accept-charset="utf-8" enctype="multipart/form-data">
                            <div class="post_photo">
                                <input type="file" name="photo"/>
                            </div>
                            <input style="display: none;" name="mode" value="1"/>
                            <span>Write new post!</span>
                            <div class="post_title">
                                <span class="post_text">Post-Titel:</span>
                                <input class="input_field" type="text" name="title" />
                            </div>
                            <div class="post_text">
                                <div class="input_container">
                                    <span class="post_textarea">Post-Text:</span>
                                    <textarea class="input_field" type="text" name="text" ></textarea>
                                </div>
                            </div>
                            <div class="post_tags">
                                <span class="post_text">Post-Tags:</span>
                                <input class="input_field" type="text" name="tags" />
                            </div>
                            <div class="post_finish">
                                <div>Fertig?</div>
                                <input type="submit" value="Ver&ouml;ffentlichen!"/>
                            </div>
                        </form>
                    </div>
                    <?php
                } else if (isset($return) && $return) {
                    ?>
                    <div class="page_content">
                        <div>
                            <span>Post erfolgreich erstellt!</span><br/><br/>
                            <a href="../index.php" target="_blank">Post anschauen!</a><br/><br/>
                            <a href="index.php">Zur&uuml;ck</a>
                        </div>
                    </div>
                    <?php
                } else if (isset($return) && !$return) {
                    ?>
                    <div class="page_content">
                        <div>
                            <span>Post konnte nicht erstellt werden!</span><br/><br/>
                            <a href="index.php?sm=wnp" target="_self">Erneut versuchen!</a><br/><br/>
                            <a href="index.php">Zur&uuml;ck</a>
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