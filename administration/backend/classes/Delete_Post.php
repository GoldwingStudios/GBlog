<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Delete_Post {

    public function Delete_Specific_Post($post_id) {
        $connection = new sql_connect();
        $this->connection = $connection->mysqli();
        $id = intval($post_id);

        $sql_str = "DELETE FROM blog_posts WHERE `post_id`=? ";
        if ($stmt = $this->connection->prepare($sql_str)) {
            $stmt->bind_param("i", $id);
            $return = $stmt->execute(); //returns true if succeed and otherwise false
        }
        $this->connection->close();
        $this->connection = null;
        $stmt = null;

        return $return;
    }

}
