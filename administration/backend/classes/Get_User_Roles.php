<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Get_User_Roles {

    public function User_Roles() {
        $User_Type = $_SESSION["User_Type"];
        $xml_path = "./blog_config/blog_roles.xml";
        $xml_file = simplexml_load_file($xml_path);
        $xml_file_ = $xml_file->xpath('//*[@role="' . $User_Type . '"]');
        $this->output_roles($xml_file_[0]);
    }

    private function output_roles($role) {
        foreach ($role->role as $current_role) {
            if (isset($current_role->role)) {
                $this->output_roles($current_role);
            }
            $role_ = $current_role->attributes();
            $role_type = (string) $role_->role;
            echo "<tr>";
            echo "<td><b>" . $role_type . "</b></td>";
            echo "</tr>";
            $this->output_names_for_role($role_type);
            echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="cursor: pointer;" id="AddUser_' . $this->replace_special_char($role_type) . '"><b><u>Hinzuf&uuml;gen?</u></b></td></tr>';
            if ($current_role instanceof SimpleXMLElement) {
                $roles = $current_role->xpath("role");
            }
            if (is_array($roles)) {
                $this->output_roles($roles);
            }
        }
    }

    private function output_names_for_role($role_type) {
        $sql_connect = new sql_connect();
        $connection = $sql_connect->mysqli();
        $users = array();
        $user_config_sql = "SELECT * FROM blog_users WHERE usr_type = ? ";

        if ($stmt = $connection->prepare($user_config_sql)) {
            $stmt->bind_param("s", $role_type);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        foreach ($users as $user) {
            $username = $this->replace_special_char($user["usr_username"]);
            echo "<tr><td>&nbsp;</td><td>" . $user["usr_username"] . "</td><td " . 'style="cursor: pointer;" onclick=\'window.location.href="index.php?sm=ums&mode=del&name=' . $username .
            '"\'>Entfernen!</td></tr>';
        }
    }

    private function replace_special_char($username) {
        $clean_str = str_replace(" ", "_", $username);
        $clean_str = str_replace("ü", "ue", $clean_str);
        $clean_str = str_replace("ö", "oe", $clean_str);
        $clean_str = str_replace("ä", "ae", $clean_str);
        $clean_str = str_replace("Ü", "Ue", $clean_str);
        $clean_str = str_replace("O", "Oe", $clean_str);
        $clean_str = str_replace("Ä", "Ae", $clean_str);
        $clean_str = str_replace("ß", "(ss)", $clean_str);
        return $clean_str;
    }

}
