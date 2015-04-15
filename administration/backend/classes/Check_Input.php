/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php

class Check_Input {

    function Check($input) {
        if (!$html = $this->Check_Input_For_Html($input)) {
            if (!$sql = $this->Check_Input_For_Sql($input)) {
                $this->status = true;
            } else {
                $this->status = false;
                $this->message = "Contains SQL!";
            }
        } else {
            $this->status = false;
            $this->message = "Contains HTML!";
        }
    }

    private function Check_Input_For_Html($string) {
        if ($string != strip_tags($string)) {
            return true;
        } else {
            return false;
        }
    }

    private function Check_Input_For_Sql($string) {
        $array = ["SELECT", "UPDATE", "DELETE"];
        if (in_array($string, $array)) {
            return true;
        } else {
            return false;
        }
    }

}
