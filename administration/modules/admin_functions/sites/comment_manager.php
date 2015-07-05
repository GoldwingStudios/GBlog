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
if (isset($id) && isset($cmd)) {
    $Comment_Processor = new Comment_Processor();
    $Comment_Processor->Process_Comment($id, $cmd);
}
$Comment_Loader = new Comment_Loader();
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
                    <span class="page_description">Hier k&ouml;nnen Sie die alle Kommentare verwalten!</span>
                </div>
                <div class="page_content">
                    <div class="comment_page">
                        <?php
                        $Comment_Loader->Load_Comments();
                        ?>
                    </div>
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