<?php
/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$post_id = filter_input(INPUT_GET, "id");
$mode = filter_input(INPUT_GET, "m");
$return_post = "";
$edit_return = "";
if ((isset($mode) || isset($post_id)) && $_SESSION["Logged_In"]) {
    if (!isset($mode) && isset($post_id)) {
        $Show_Post_For_Edit = new Show_Post_For_Edit();
        $return_post = $Show_Post_For_Edit->Load_Post_For_Edit($post_id);
    } else {
        switch ($mode) {
            case "edm":
                $Edit_Post = new Edit_Post();
                $edit_return = $Edit_Post->Edit();
                break;
            case "del":
                $Delete_Post = new Delete_Post();
                $removed = $Delete_Post->Delete_Specific_Post($post_id);
                break;
            case "soh"://show or hide - to change the visibillity in the post-xml
                $function = filter_input(INPUT_GET, "func");
                $Show_Hide_Post = new Show_Hide_Post();
                $Show_Hide_Post->Set_Visibility($post_id, $function);
                break;
        }
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
                    <span class="page_description">Hier k&ouml;nnen Sie bestehende Posts editieren!</span>
                </div>
                <div class="page_content">

                    <?php
                    if (isset($return_post) && $return_post == "" && !is_array($edit_return)) {
                        ?> 
                        <div class="post_list">
                            <?php
                            $luap = new List_Up_Posts();
                            $luap->List_Up_All_Posts($edit_return, $post_id);
                            ?>
                        </div>
                        <?php
                    } else if (isset($return_post) && $return_post !== "" || is_array($edit_return)) {
                        include ("modules/UI/edit_post/edit_post_form.php");
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
</div>