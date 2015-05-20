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
        $user = $this->replace_special_char($user);
        $user_file = $this->get_user_xml_file();
        $user_config = $user_file->xpath('user');
        foreach ($user_config as $user_) {
            if ($user_->username == $user) {
                $domRef = dom_import_simplexml($user_file);
                $remove_node = dom_import_simplexml($user_);
                $domRef->removeChild($remove_node);
                $user_config = simplexml_import_dom($domRef);
                $success = $user_config->asXML("user_config/user_config.xml");
                break;
            }
        }
    }

    public function Add_User() {
        $user_file = $this->get_user_xml_file();
        $user_name = filter_input(INPUT_POST, "user_name");
        $user_password = filter_input(INPUT_POST, "user_password");
        $user_role = filter_input(INPUT_POST, "NewUser_Form_attr");
        $newUser = $user_file->addChild('user');
        $newUser->addAttribute('type', $user_role);
        $newUser->addChild('username', $user_name);
        $newUser->addChild('password', md5($user_password));
        $success = $user_file->asXML("user_config/user_config.xml");
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

    private function get_user_xml_file() {
        $path = "user_config/user_config.xml";
        return simplexml_load_file($path);
    }

    private function replace_special_char($username) {
        $clean_str = str_replace("_", " ", $username);
        return $clean_str;
    }

}
