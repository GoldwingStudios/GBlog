<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class page {

    public function _page() {
        $DB_Connect = new DB_Connect();
        $param = filter_input(INPUT_GET, "p");
        $lang = filter_input(INPUT_GET, "l");
        if (!isset($param)) {
            $page = "1";
            $query = 'Select * '
                    . 'FROM sites '
                    . 'WHERE id ="' . $page . '" AND visible="1"';
        } else if (is_numeric($param)) {
            $query = 'Select * '
                    . 'FROM sites '
                    . 'WHERE id ="' . $param . '" AND visible="1"';
        } else {
            $query = 'Select * '
                    . 'FROM sites '
                    . 'WHERE id="0" AND visible="1"';
        }

        $this->lang_set($lang);
        $db_page = $DB_Connect->Return_PDO_Row($query);
        define("content", "frontend/sites/" . $db_page["template"] . ".php");
        define("css", $db_page["template"] . ".css");
    }

    private function lang_set($lang) {
        if (isset($lang)) {
            define("TEXT_LANG", $lang);
        } else {
            define("TEXT_LANG", lang);
        }
    }

}

?>