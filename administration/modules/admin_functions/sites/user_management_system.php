<!--/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */-->
<?php
$mode = filter_input(INPUT_GET, "mode");
$username = filter_input(INPUT_GET, "name");
$username_ = filter_input(INPUT_POST, "user_name");
$user_management = new User_Management();
if (isset($mode) && (isset($username) || isset($username_))) {
    $username = isset($username) ? $username : $username_;
    $user_management->Choose_Mode($mode, $username);
}
?>
<script src="modules/js/USM_AddNewUser.js"></script>
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
                    <span class="page_description">Manage the user roles for your blog administration!</span>
                </div>
                <div class="page_content">
                    <br><span>Current User-role: <?php echo $_SESSION["User_Type"]; ?></span>
                    <table>
                        <tr>
                            <td>Benutzer-Rolle</td>
                            <td>Benutzer-Name</td>
                            <td>Entfernen?</td>
                        </tr>
                        <?php
                        $user_management->User_Roles();
                        ?>
                    </table>
                    <div class="AddUserForm">
                        <br>
                        <span>Add new User to Role: <span id="NewUserRole"></span></span>
                        <form id="NewUser_Form" method="post" action="index.php?sm=ums&mode=add">
                            <input style="display: none;" id="NewUser_Form_attr" name="NewUser_Form_attr"/>
                            <div class="user_name_container">
                                <span>Username:</span>
                                <input name="user_name" />
                            </div><br>
                            <div class="user_password_container">
                                <span>Password:</span>
                                <input name="user_password" />
                            </div>
                            <br>
                            <div class="submit_NewUser" id="submit_NewUser">Add</div>
                            <div class="CloseAddForm" id="CloseAddForm">Cancel</div>
                        </form>
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