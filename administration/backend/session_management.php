<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
session_start();
if (!$_SESSION["Logged_In"]) {
    $_SESSION["Logged_In"] = null;
    $_SESSION["Login_Error"] = null;
    $usr = filter_input(INPUT_POST, "usr_post");
    $psw = filter_input(INPUT_POST, "psw_post");
    $user_config_path = "./user_config/user_config.xml";
    $user_config = simplexml_load_file($user_config_path);
}



if (!$_SESSION["Logged_In"] && isset($usr) && isset($psw)) {
    $user_config = $user_config->xpath('user');
    foreach ($user_config as $user) {
        if ($user->username == $usr) {
            $user_config = $user;
            break;
        }
    }
    $usr_psw = md5($psw);
    $confg_usr = $user_config->username;
    $confg_psw = $user_config->password;
    $user_type = $user_config->attributes();
    $user_type = (string) $user_type->type;
    if ($usr == $confg_usr && $usr_psw == $confg_psw) {
        $_SESSION["Logged_In"] = TRUE;
        $_SESSION["Login_Error"] = FALSE;
        $_SESSION["User"] = $usr;
        $_SESSION["User_Type"] = $user_type;
    } else {
        echo '<script>alert("There was an error during the Login-Process!\nPlease check your input and try again!");</script>';
        $_SESSION["Login_Error"] = TRUE;
    }
} else if (!$_SESSION["Logged_In"] && !isset($usr) && !isset($psw)) {
    if (!$_SESSION["Logged_In"] && isset($_SESSION) && $_SESSION["Login_Error"] !== null) {
        echo '<script>alert("There was an error during the Login-Process!\nPlease check your input and try again!");</script>';
        $_SESSION["Login_Error"] = TRUE;
    }
}