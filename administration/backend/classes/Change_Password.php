<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Change_Password {

    public function __construct() {
        $this->Connection = new DB_Connect();
    }

    public function Set_New_Password() {
        $Old_Password = md5(filter_input(INPUT_POST, "old_pass"));
        $UserName = filter_input(INPUT_POST, "current_user");

        $Sql_Query = "SELECT usr_password FROM blog_users WHERE usr_username = :UserName ";
        $Parameter = array(":UserName" => $UserName);
        $Current_Password = $this->Connection->Return_PDO_Row($Sql_Query, $Parameter);

        $same = $Old_Password == $Current_Password;
        if ($Old_Password == $Current_Password["usr_password"]) {
            $New_Password = md5(filter_input(INPUT_POST, "new_pass"));
            $New_Password_Confirm = md5(filter_input(INPUT_POST, "new_pass_confirmation"));
            $same_p = $New_Password == $New_Password_Confirm;
            if ($New_Password == $New_Password_Confirm && $New_Password != $Current_Password) {
                $Sql_Query = "UPDATE blog_users SET usr_password = :User_Password WHERE usr_username = :Username ";
                $Parameter = array(":Username" => $UserName, ":User_Password" => $New_Password);
                return $this->Connection->Execute_PDO_Command($Sql_Query, $Parameter);
            } else if ($New_Password == $New_Password_Confirm && $New_Password == $Current_Password) {
                return 2;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

}
