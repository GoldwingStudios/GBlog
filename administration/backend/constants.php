<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
header("Content-type:text/html; charset=utf-8");
define("lang", "en");
date_default_timezone_set("Europe/Berlin");
define("PAGE_TEXT_LANGUAGE", filter_input(INPUT_GET, "l"));
define("PAGE_SPECIAL_MODE_TYPE", filter_input(INPUT_GET, "sm"));

if ($_SESSION != null) {
    define("USER_LOGGED_IN", (isset($_SESSION["Logged_In"]) & $_SESSION["Logged_In"]));
    define("USER_LOGIN_ERROR", (isset($_SESSION["Login_Error"]) & $_SESSION["Login_Error"]));
} else {
    define("USER_LOGGED_IN", FALSE);
    define("USER_LOGIN_ERROR", FALSE);
}

if (PAGE_SPECIAL_MODE_TYPE != "") {
    switch (PAGE_SPECIAL_MODE_TYPE) {
        case "cp":
            $content = "";
            define("PAGE_SPECIAL_MODE", TRUE);
            define("PAGE_CURRENT_SITE", "CHANGE PASSWORD");
            break;
        case "wnp":
            $content = "";
            define("PAGE_SPECIAL_MODE", TRUE);
            define("PAGE_CURRENT_SITE", "WRITE NEW POST");
            break;
        case "edit":
            $content = "";
            define("PAGE_SPECIAL_MODE", TRUE);
            define("PAGE_CURRENT_SITE", "EDIT POST");
            break;
        case "some":
            $content = "";
            define("PAGE_SPECIAL_MODE", TRUE);
            define("PAGE_CURRENT_SITE", "SOCIAL MEDIA LINKS");
            break;
        case "ums":
            $content = "";
            define("PAGE_SPECIAL_MODE", TRUE);
            define("PAGE_CURRENT_SITE", "USER MANAGEMENT SYSTEM");
            break;
        case "comma":
            $content = "";
            define("PAGE_SPECIAL_MODE", TRUE);
            define("PAGE_CURRENT_SITE", "COMMENT MANAGER");
            break;
    }
} else {
    $content = "";
    define("PAGE_SPECIAL_MODE", FALSE);
    define("PAGE_CURRENT_SITE", "Home");
}
