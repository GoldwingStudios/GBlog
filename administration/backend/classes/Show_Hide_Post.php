<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Show_Hide_Post {

    function __construct() {
        $connection = new sql_connect();
        $this->connection = $connection->mysqli();
    }

    public function Set_Visibility($post_id, $function) {
        switch ($function) {
            case "vis":
                $id = intval($post_id);

                $sql_str = "UPDATE blog_posts SET `post_visible`=? WHERE `post_id`=?";
                $visible = 1;
                if ($stmt = $this->connection->prepare($sql_str)) {
                    $stmt->bind_param("ii", $visible, $id);
                    $return = $stmt->execute(); //returns true if succeed and otherwise false
                }
                $this->connection->close();
                $this->connection = null;
                $stmt = null;
                break;
            case "hid":
                $id = intval($post_id);

                $sql_str = "UPDATE blog_posts SET `post_visible`=? WHERE `post_id`=?";
                $visible = 0;
                if ($stmt = $this->connection->prepare($sql_str)) {
                    $stmt->bind_param("ii", $visible, $id);
                    $return = $stmt->execute(); //returns true if succeed and otherwise false
                }
                $this->connection->close();
                $this->connection = null;
                $stmt = null;
                break;
        }
    }

}
