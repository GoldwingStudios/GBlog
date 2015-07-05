<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Write_Post {

    public function Write_Post_($title, $text, $tags) {
        $connection = new sql_connect();
        $connection = $connection->mysqli();
        $preview = $text; //$this->get_preview($text);
        $date = $this->get_date();

        $sql_str = "INSERT INTO blog_posts (`post_title`, `post_text`, `post_date`, `post_tags`) VALUES (?, ?, ?, ?)";

        if ($stmt = $connection->prepare($sql_str)) {
            $stmt->bind_param("ssss", $title, $preview, $date, $tags);
            $return = $stmt->execute(); //returns true if succeed and otherwise false
        }
        $connection->close();
        return $return;
    }

    private function get_date() {
        $date = new DateTime();
        return $date->format("Y-m-d H:i:s");
    }
}
