<!--/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */-->
 <?php
 $id = filter_input(INPUT_GET, "id");
 $cmd = filter_input(INPUT_GET, "cmd");
 $Comment_Processor = new Comment_Processor();
 if (isset($id) && isset($cmd)) {
    $Comment_Processor->Process_Comment($id, $cmd);
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
                    <span class="page_description">Admit the comments which have been posted on your site!</span>
                </div>
                <div class="page_content">
                    <div class="comment_page">
                        <?php
                        $Comment_Processor->Load_Comments();
                        ?>
                    </div>
                </div>
                <?php
            } else {
                echo "<script>window.location.replace('./index.php');</script>";
            }
            ?>
        </div>
    </div>
</div>