<!--/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */-->
 <?php
 include "modules/admin_functions/functions/sites/delete_installer.php";
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
            <!--<li><a href="?sm=blw">Change Blog Layout</a></li>-->
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