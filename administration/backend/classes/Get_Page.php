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
        if (PAGE_SPECIAL_MODE == FALSE) {
            define("PAGE_CONTENT", "./frontend/sites/start.php");
            define("PAGE_CSS", "start.css");
        } else {
            $Page_Name = str_replace(" ", "_", strtolower(PAGE_CURRENT_SITE));
            define("PAGE_CONTENT", "modules/admin_functions/sites/" . $Page_Name . ".php");
            define("PAGE_CSS", $Page_Name . ".css");
        }
    }

}

?>