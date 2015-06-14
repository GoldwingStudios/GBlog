<!--/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */-->
<div class="comment_section">
    <div class="comments_container_for_post">
        <?php
        $Get_Comments = new Get_Comments();
        $count = $Get_Comments->Comments_Count($id);
        if ($count > 0) {
            $Get_Comments->Show_Comments($id);
        } else {
            ?>
            <div class="post_comment">
                <div class="post_comment_text">
                    No Comments!
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    $new_comment = filter_input(INPUT_POST, "new_comment");
    if ($new_comment) {
        $Save_Comment_Request = new Save_Comment_Request();
        $return = $Save_Comment_Request->write_comment_to_file($id);
        echo "<script>console.log($id);</script>";
        if ($return) {
            ?>
            <div class="comment_input_container">
                Comment created!<br>
                Please be informed that your comment needs to be activated by the Administrator!
            </div>
            <?php
        } else {
            ?>
            <div class="comment_input_container">
                Error occured!<br>
                Please reload page and try again!
            </div>
            <?php
        }
    } else {
        ?>
        <div class="comment_input_container">
            <form method="post" action="index.php?post=<?php echo $id; ?>" accept-charset="utf-8">
                <input style="display: none;" name="new_comment" value="1" />
                <div class="comment_user_name">
                    <input name="user_name" placeholder="Type in your name!"/>
                </div>
                <div class="comment_user_mail">
                    <input class="comment_user_mail" name="user_mail" placeholder="Type in your mail!"/>
                </div>
                <div class="comment_user_text">
                    <textarea class="comment_user_text" name="user_text" placeholder="Type in your comment!"></textarea>
                </div>
                <input class="comment_user_send" type="submit" value="Kommentar senden" />
            </form>
        </div>
        <?php
    }
    ?>
</div>