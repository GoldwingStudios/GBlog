<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class page {

    function _page() {
        $sql = new sql_connect();
        $param = $_GET["p"];
        $lang = $_GET["l"];
        $news = false;
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

        if (isset($lang)) {
            define("text_lang", $lang);
        } else {
            define("text_lang", lang);
        }
        $db_page = $sql->return_row($query);
        define("content", "frontend/sites/" . $db_page["template"] . ".php");
        define("css", $db_page["template"] . ".css");
    }

}
?>