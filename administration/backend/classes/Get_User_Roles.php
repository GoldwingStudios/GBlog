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
            echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="cursor: pointer;" id="AddUser_' . $this->replace_special_char($role_type) . '">Hinzuf&uuml;gen?</td></tr>';
            if ($current_role instanceof SimpleXMLElement) {
                $roles = $current_role->xpath("role");
            }
            if (is_array($roles)) {
                $this->output_roles($roles);
            }
        }
    }

    private function output_names_for_role($role_type) {
        $user_xml = $this->get_user_xml_file();
        $user_for_type = $user_xml->xpath('user[@type="' . $role_type . '"]');
        foreach ($user_for_type as $user) {
            $username = $this->replace_special_char($user->username);
            echo "<tr><td>&nbsp;</td><td>$user->username</td><td " . 'style="cursor: pointer;" onclick=\'window.location.href="index.php?sm=ums&mode=del&name=' . $username .
            '"\'>Entfernen!</td></tr>';
        }
    }

    private function get_user_xml_file() {
        $path = "user_config/user_config.xml";
        return simplexml_load_file($path);
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
