<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
session_start();
if (!isset($_SESSION["Logged_In"]) && !$_SESSION["Logged_In"]) {
    $sql_connect = new sql_connect();
    $connection = $sql_connect->mysqli();
    $_SESSION["Logged_In"] = null;
    $_SESSION["Login_Error"] = null;
    $usr = filter_input(INPUT_POST, "usr_post");
    $psw = filter_input(INPUT_POST, "psw_post");
}



if (!isset($_SESSION["Logged_In"]) && !$_SESSION["Logged_In"] && isset($usr) && isset($psw)) {
    $user_config_sql = "SELECT * FROM blog_users WHERE usr_username = ? ";

    if ($stmt = $connection->prepare($user_config_sql)) {
        $stmt->bind_param("s", $usr);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $user_config = $row;
        }
    }

    $usr_psw = md5($psw);
    $confg_usr = $user_config["usr_username"];
    $confg_psw = $user_config["usr_password"];
    $user_type = $user_config["usr_type"];
    if ($usr == $confg_usr && $usr_psw == $confg_psw) {
        $_SESSION["Logged_In"] = TRUE;
        $_SESSION["Login_Error"] = FALSE;
        $_SESSION["User"] = $usr;
        $_SESSION["User_Type"] = $user_type;
        unset($_POST["usr_post"]);
        unset($_POST["psw_post"]);
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