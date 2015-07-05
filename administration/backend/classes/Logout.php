<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Logout {

    function __construct() {
        
    }

    public function Run() {
        session_start();
        session_destroy();
        $cookieParams = session_get_cookie_params();
        setcookie(session_name(), '', 0, $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);

        $_SESSION = array();
        echo "<script>window.location.replace('./index.php');</script>";
    }

}

?>