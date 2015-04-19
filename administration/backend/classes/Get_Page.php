<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Page {

    public function _Page() {
        global $content, $css;
        if ($_SESSION["sm"] == null) {
            $sql = new Sql_Connect();
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

            if (isset($lang)) {
                define("text_lang", $lang);
            } else {
                define("text_lang", lang);
            }
            $db_page = $sql->return_row($query);

            $content = "./frontend/sites/" . $db_page["template"] . ".php";
            $css = $db_page["template"] . ".css";
        } else {
            $page_name = strtolower($_SESSION["current_page"]);
            $page_name_ = str_replace(" ", "_", $page_name);
            $content = "modules/admin_functions/sites/" . $page_name_ . ".php";
            $css = $page_name_ . ".css";
        }
    }

}

?>