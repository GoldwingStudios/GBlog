<!--/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */-->
<div class="blog__fullentry__commentsection">
    <div class="blog__fullentry_comments">
        <?php
        $Get_Comments = new Get_Comments();
        $count = $Get_Comments->Comments_Count($Post_ID_numeric);
        if ($count > 0) {
            $Get_Comments->Show_Comments($Post_ID_numeric);
        } else {
            ?>
            <div class="blog__fullentry__comment">
                <div class="comment__data">
                    <h1 class="comment__name" style="width: 100%; text-align: center; margin-top: 10px;">No Comments available</h1>
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
        $return = $Save_Comment_Request->Write_Comment($Post_ID_numeric);
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
        <div class="blog__fullentry__newcomment">
            <form method="post" action="index.php?post=<?php echo $Post_ID_string; ?>" accept-charset="utf-8">
                <input type="text" style="display: none;" name="new_comment" value="1" />
                <input type="text" name="user_name" placeholder="Your name" style="margin-right: 5%;" />
                <input type="text" class="comment_user_mail" name="user_mail" placeholder="Your E-Mail"/>
                <textarea class="comment_user_text" name="user_text" placeholder="Get creative here."></textarea>
                <input class="comment_user_send" type="submit" value="Send Comment" />
            </form>
        </div>
        <?php
    }
    ?>
</div>