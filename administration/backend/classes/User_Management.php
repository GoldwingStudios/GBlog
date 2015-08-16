<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class User_Management {

    public function __construct() {
        $this->Connection = new DB_Connect();
        $this->User_Roles = new User_Roles();
        $this->User_Type = $_SESSION["User_Type"];
    }

    private function Delete_User($user) {
        $Sql_Query = "DELETE FROM blog_users WHERE usr_username = :Username ";
        $Paramters = array(":Username" => $user);
        $return = $this->Connection->Execute_PDO_Command($Sql_Query, $Paramters);
    }

    private function Add_User() {
        $Username = filter_input(INPUT_POST, "user_name");
        $User_Password = md5(filter_input(INPUT_POST, "user_password"));
        $User_Role = str_replace(" ", "_", filter_input(INPUT_POST, "NewUser_Form_attr"));

        $Sql_Query = "INSERT INTO blog_users (`usr_type`,`usr_username`,`usr_password`) VALUES(:User_Type, :User_Username, :User_Password);";
        $Paramters = array(":User_Type" => $User_Role, ":User_Username" => $Username, ":User_Password" => $User_Password);
        $return = $this->Connection->Execute_PDO_Command($Sql_Query, $Paramters);
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

    public function User_Roles() {
        $this->output_roles();
    }

    private function output_roles() {
        $r = $this->User_Roles->getConstants();
        foreach ($r as $key => $current_role) {
            if ($key != $this->User_Type) {
                $role_type = (string) $key;
                echo "<tr>";
                echo "<td><b>" . str_replace("_", " ", $role_type) . "</b></td>";
                echo "</tr>";
                $this->output_names_for_role($role_type);
                echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="cursor: pointer;" id="AddUser_' . $this->replace_special_char($role_type) . '"><b><u>Hinzuf&uuml;gen?</u></b></td></tr>';
            }
        }
    }

    private function output_names_for_role($Role_Type) {
        $Sql_Query = "SELECT * FROM blog_users WHERE usr_type = :User_Type ";
        $Parameter = array(":User_Type" => $Role_Type);
        $Users = $this->Connection->Return_PDO_Array($Sql_Query, $Parameter);

        if (!empty($Users) && $Users != NULL)
            foreach ($Users as $User) {
                $Username = $this->replace_special_char($User["usr_username"]);
                echo "<tr><td>&nbsp;</td><td>" . $User["usr_username"] . "</td><td " . 'style="cursor: pointer;" onclick=\'window.location.href="index.php?sm=ums&mode=del&name=' . $Username .
                '"\'>Entfernen!</td></tr>';
            }
    }

    private function replace_special_char($Username) {
        $Clean_String = str_replace(" ", "_", $Username);
        $Clean_String = str_replace("ü", "ue", $Clean_String);
        $Clean_String = str_replace("ö", "oe", $Clean_String);
        $Clean_String = str_replace("ä", "ae", $Clean_String);
        $Clean_String = str_replace("Ü", "Ue", $Clean_String);
        $Clean_String = str_replace("O", "Oe", $Clean_String);
        $Clean_String = str_replace("Ä", "Ae", $Clean_String);
        $Clean_String = str_replace("ß", "(ss)", $Clean_String);
        return $Clean_String;
    }

}
