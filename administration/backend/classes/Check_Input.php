<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Check_Input {

    public function Check($input) {
        if (!$html = $this->Check_Input_For_Html($input)) {
            if (!$sql = $this->Check_Input_For_Sql($input)) {
                $this->status = TRUE;
            } else {
                $this->status = FALSE;
                $this->message = "Contains SQL!";
            }
        } else {
            $this->status = FALSE;
            $this->message = "Contains HTML!";
        }
    }

    private function Check_Input_For_Html($string) {
        if ($string != strip_tags($string)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function Check_Input_For_Sql($string) {
        $array = array("SELECT", "UPDATE", "DELETE");
        if (in_array($string, $array)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
