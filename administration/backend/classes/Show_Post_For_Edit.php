<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Show_Post_For_Edit {

    function Load_Post_For_Edit($id) {
        $id = intval($id);
        $load_string = "../post_data/posts/post_$id.xml";
        $post = simplexml_load_file($load_string);
        return $post;
    }

}
