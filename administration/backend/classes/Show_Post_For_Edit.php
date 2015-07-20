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
        $post = array();
        $connection = new sql_connect();
        $connection = $connection->mysqli();

        $sql_string = "SELECT * FROM blog_posts WHERE post_id=? ";

        if ($stmt = $connection->prepare($sql_string)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($post["id"], $post["title"], $post["text"], $post["date"], $post["visible"], $post["tags"], $post["image_path"]);
            $stmt->fetch();
        }
        return $post;
    }

}
