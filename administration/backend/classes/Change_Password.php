<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Change_Password {

    function __construct() {
        $user_config_path = "./user_config/user_config.xml";
        $this->user_config = simplexml_load_file($user_config_path);
    }

    function Set_New_Password() {
        $sql_connect = new sql_connect();
        $connection = $sql_connect->mysqli();
        $old_pass = md5(filter_input(INPUT_POST, "old_pass"));
        $current_user = filter_input(INPUT_POST, "current_user");

        $user_config_sql = "SELECT usr_password FROM blog_users WHERE usr_username = ? ";

        if ($stmt = $connection->prepare($user_config_sql)) {
            $stmt->bind_param("s", $current_user);
            $stmt->execute();
            $stmt->bind_result($current_pass);
            $stmt->fetch();
        }

        $same = $old_pass == $current_pass;
        if ($old_pass == $current_pass) {
            $new_pass = md5(filter_input(INPUT_POST, "new_pass"));
            $new_pass_conf = md5(filter_input(INPUT_POST, "new_pass_confirmation"));
            $same_p = $new_pass == $new_pass_conf;
            if ($new_pass == $new_pass_conf && $new_pass != $current_pass) {
                $sql_connect = new sql_connect();
                $connection = $sql_connect->mysqli();
                $user_config_sql_ = "UPDATE blog_users SET usr_password=? WHERE usr_username=? ";

                if ($stmt = $connection->prepare($user_config_sql_)) {
                    $stmt->bind_param("ss", $new_pass, $current_user);
                    $x = $stmt->execute();
                    return $x;
                }
            } else if ($new_pass == $new_pass_conf && $new_pass == $current_pass) {
                return 2;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

}
