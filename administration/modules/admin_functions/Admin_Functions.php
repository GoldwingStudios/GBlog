<!--/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */-->
<?php
if (file_exists("installer.php")) {
    ?>
    <div class="alert alert-warning">
        <span>
            The Installer-File still exists!<br/>Please delete it soon!
        </span>
        <a class="btn btn-info delete-installer" href="modules/admin_functions/functions/delete_installer.php">
            Delete!
        </a>
    </div>
    <?php
}
$user_type = $_SESSION["User_Type"];
if ($user_type == "Blog-Autor" || $user_type == "Administrator") {
    ?>
    <div class="function_category">
        <u><b><span>Posts</span></b></u>
        <ul>
            <li><a href="?sm=wnp"><b>Write a new Post!</b></a></li>
            <li><a href="?sm=edit">Edit Blogpost</a></li>
            <li><a href="?sm=comma">Comment Manager</a></li>
        </ul>
    </div>
    <?php
}
if ($user_type == "Account Manager" || $user_type == "Administrator") {
    ?>
    <div class="function_category">
        <u><b><span>Blog Functions</span></b></u>
        <ul>
            <!--        <li><a href="?sm=ubf">Updates</a></li>-->
            <li><a href="?sm=ums">User Management System</a></li>
            <li><a href="?sm=some">SocialMedia Links</a></li>
            <!--<li><a href="?sm=analytics">View Analytics</a></li>-->
        </ul>
    </div>
    <?php
}
?>
<div class="function_category">
    <u><b><span>User Functions</span></b></u>
    <ul>
        <li><a href="?sm=cp">Change Password</a></li>
    </ul>
</div>