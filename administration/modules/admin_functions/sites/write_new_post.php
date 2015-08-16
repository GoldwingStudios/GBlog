<?php
/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$Write_Return = null;
$post_submit = filter_input(INPUT_POST, "post_submit");
if (isset($post_submit) && $post_submit == 1 && USER_LOGGED_IN) {
    $post_title = filter_input(INPUT_POST, "post_title");
    $post_text = filter_input(INPUT_POST, "post_text");
    $post_tags = filter_input(INPUT_POST, "post_tags");
    if (isset($post_title) && isset($post_text)) {
        $Write_Post = new Write_Post();
        $Write_Return = $Write_Post->Write_New_Post($post_title, $post_text, $post_tags);
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
        if (USER_LOGGED_IN) {
            ?>
            <div class="content_layout">
                <div class="page_title">
                    <span class="page_description">Here you can add new posts to your blog site!</span>
                </div>
                <?php
                if (!isset($Write_Return) && !$Write_Return) {
                    ?>
                    <div class="page_content">
                        <form method="post" action="index.php?sm=wnp" accept-charset="utf-8" enctype="multipart/form-data">

                            <input style="display: none;" name="post_submit" value="1"/>
                            <span>Write new post!</span>
                            <div class="post_title">
                                <span class="post_text">Post-Titel:</span>
                                <input class="input_field" type="text" name="post_title" />
                            </div>
                            <div class="post_text">
                                <div class="input_container">
                                    <span class="post_textarea">Post-Text:</span>
                                    <textarea class="input_field" type="text" name="post_text" ></textarea>
                                </div>
                            </div>
                            <div class="post_tags">
                                <span class="post_text">Post-Tags:</span>
                                <input class="input_field" type="text" name="post_tags" />
                            </div>
                            <div class="post_photo">
                                <span class="post_photo_text">Choose your upload image!</span>
                                <input class="post_photo_upload" type="file" name="post_image"/>
                            </div><br/>
                            <div class="post_finish">
                                <p>Ready?</p>
                                <input type="submit" value="Submit!"/>
                            </div>
                        </form>
                    </div>
                    <?php
                } else if (!empty($Write_Return)) {
                    ?>
                    <div class="page_content">
                        <div>
                            <span>Post erfolgreich erstellt!</span><br/><br/>
                            <a href="../index.php" target="_blank">Post anschauen!</a><br/><br/>
                            <a href="index.php">Zur&uuml;ck</a>
                        </div>
                    </div>
                    <?php
                } else if (isset($Write_Return) && !$Write_Return) {
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
        } else {
            echo "<script>window.location.replace('./index.php');</script>";
        }
        ?>
    </div>