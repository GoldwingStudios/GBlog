<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class User_Management {

    public function Delete_User($user) {
        $sql_connect = new sql_connect();
        $connection = $sql_connect->mysqli();
        $user_config_sql = "DELETE FROM blog_users WHERE usr_username = ? ";

        if ($stmt = $connection->prepare($user_config_sql)) {
            $stmt->bind_param("s", $user);
            $deleted = $stmt->execute();
        }
    }

    public function Add_User() {
        $sql_connect = new sql_connect();
        $connection = $sql_connect->mysqli();
        $user_name = filter_input(INPUT_POST, "user_name");
        $user_password = filter_input(INPUT_POST, "user_password");
        $user_role = filter_input(INPUT_POST, "NewUser_Form_attr");

        $user_config_sql = "INSERT INTO blog_users (`usr_type`,`usr_username`,`usr_password`) VALUES(?, ?, ?);";

        if ($stmt = $connection->prepare($user_config_sql)) {
            $stmt->bind_param("sss", $user_role, $user_name, md5($user_password));
            $added = $stmt->execute();
        }
    }

    public function Choose_Mode($mode, $user) {
        switch ($mode) {
            case "del":
                $this->Delete_User($user);
                break;
            case "add":
                $this->Add_User();
                break;
        }
    }

}
