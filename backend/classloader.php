<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$path = "backend/classes/*.php";
$classes = glob($path);

foreach ($classes as $class) {
    include $class;
}

