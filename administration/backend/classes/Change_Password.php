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

    function Set_New_Password($post) {
        $old_pass = md5(filter_input(INPUT_POST, "old_pass"));
        $current_pass = $this->user_config->password;
        $same = $old_pass == $current_pass;
        if ($old_pass == $current_pass) {
            $new_pass = md5(filter_input(INPUT_POST, "new_pass"));
            $new_pass_conf = md5(filter_input(INPUT_POST, "new_pass_confirmation"));
            $same_p = $new_pass == $new_pass_conf;
            if ($new_pass == $new_pass_conf && $new_pass != $current_pass) {
                $dom = new DOMDocument;
                $dom->loadXML(file_get_contents('./user_config/user_config.xml'));

                $xpath = new DOMXPath($dom);
                $nodes = $xpath->query('//root/password');

                // password
                $node = $nodes->item(0);
                $node->nodeValue = $new_pass;

                $x = $dom->saveXML();
                $y = $dom->save('./user_config/user_config.xml');
                if ($y >= 0 && $y !== NULL) {
                    return 1;
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
