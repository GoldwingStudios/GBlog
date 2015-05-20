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

$content;
$css;

$get = filter_input(INPUT_GET, "sm");
if (isset($get)) {
    switch ($get) {
        case "cp":
            $content = "";
            $_SESSION["sm"] = true;
            $_SESSION["current_page"] = "CHANGE PASSWORD";
            break;
        case "wnp":
            $content = "";
            $_SESSION["sm"] = true;
            $_SESSION["current_page"] = "WRITE NEW POST";
            break;
        case "edit":
            $content = "";
            $_SESSION["sm"] = true;
            $_SESSION["current_page"] = "EDIT POST";
            break;
        case "some":
            $content = "";
            $_SESSION["sm"] = true;
            $_SESSION["current_page"] = "SOCIAL MEDIA LINKS";
            break;
        case "ums":
            $content = "";
            $_SESSION["sm"] = true;
            $_SESSION["current_page"] = "USER MANAGEMENT SYSTEM";
            break;
    }
} else {
    $content = "";
    $_SESSION["sm"] = false;
    $_SESSION["current_page"] = "Home";
}