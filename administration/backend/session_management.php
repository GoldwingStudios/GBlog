<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
session_start();
$Username = filter_input(INPUT_POST, "Username_Post");
$Password = filter_input(INPUT_POST, "Password_Post");
if (isset($Username) && isset($Password)) {
    if (!isset($_SESSION["Logged_In"])) {
        $_SESSION["Logged_In"] = null;
        $_SESSION["Login_Error"] = null;
        $DB_Connect = new DB_Connect();
        $User_Config_Sql = "SELECT * FROM blog_users WHERE usr_username = :UserName ";
        $Parameters = array(":UserName" => $Username);

        $User_DB_Config = $DB_Connect->Return_PDO_Row($User_Config_Sql, $Parameters);

        $User_Password = hash("sha512", $Password);
        $Config_Username = $User_DB_Config["usr_username"];
        $Config_Password = $User_DB_Config["usr_password"];
        $User_Type = $User_DB_Config["usr_type"];
        if ($Username == $Config_Username && $User_Password == $Config_Password) {
            $_SESSION["Logged_In"] = TRUE;
            $_SESSION["Login_Error"] = FALSE;
            $_SESSION["User"] = $Username;
            $_SESSION["User_Type"] = $User_Type;
            unset($_POST["usr_post"]);
            unset($_POST["psw_post"]);
        } else {
            echo '<script>alert("There was an error during the Login-Process!\nPlease check your input and try again!");</script>';
            $_SESSION["Login_Error"] = TRUE;
        }
        $Username = null;
        $Password = null;
    } else if (!$_SESSION["Logged_In"] && !isset($Username) && !isset($Password)) {
        if (!$_SESSION["Logged_In"] && isset($_SESSION) && $_SESSION["Login_Error"] !== null) {
            echo '<script>alert("There was an error during the Login-Process!\nPlease check your input and try again!");</script>';
            $_SESSION["Login_Error"] = TRUE;
        }
    }
}