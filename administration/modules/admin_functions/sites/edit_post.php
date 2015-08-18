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
if ((isset($mode) || isset($post_id)) && USER_LOGGED_IN) {
    if (!isset($mode) && isset($post_id)) {
        $Post_Edit = new Post_Edit();
        $return_post = $Post_Edit->Load_Post_For_Edit($post_id);
    } else {
        $Post_Edit = new Post_Edit();
        switch ($mode) {
            case "edm":
                $edit_return = $Post_Edit->Recreate_Post();
                break;
            case "del":
                $removed = $Post_Edit->Delete_Post($post_id);
                break;
            case "soh":
                $visibility_changed = $Post_Edit->Set_Visibility($post_id);
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
        if (USER_LOGGED_IN) {
            ?>
            <div class="content_layout">
                <div class="page_title">
                    <span class="page_description">Here you can adapt existing Posts!</span>
                </div>
                <div class="page_content">
                    <div class="edit_post_keys">
                        <div class="edit_post_keys__visible">
                            Visibility: <img class="edit_post_keys__visible_example" src="./assets/images/edit_post/visible.png"/>
                        </div>
                        <div class="edit_post_keys__delete">
                            Delete: <div class="edit_post_keys__delete_example">X</div>
                        </div>
                    </div>
                    <?php
                    if (isset($return_post) && $return_post == "" && !is_array($edit_return)) {
                        ?> 
                        <div class="post_list">
                            <?php
                            $Post_Edit = new Post_Edit();
                            $Post_Edit->List_Up_All_Valid_Posts($edit_return, $post_id);
                            ?>
                        </div>
                        <?php
                    } else if (isset($return_post) && $return_post !== "" || is_array($edit_return)) {
                        include ("modules/UI/edit_post/edit_post_form.php");
                    }
                    ?>

                </div>
                <?php
            } else {
                echo "<script>window.location.replace('./index.php');</script>";
            }
            ?>
        </div>
    </div>
</div>