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
        $image_path = $this->get_post_image($date);

        $sql_str = "INSERT INTO blog_posts (`post_title`, `post_text`, `post_date`, `post_tags`, `post_image_path`) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $connection->prepare($sql_str)) {
            $stmt->bind_param("sssss", $title, $preview, $date, $tags, $image_path);
            $return = $stmt->execute(); //returns true if succeed and otherwise false
        }
        $connection->close();
        return $return;
    }

    private function get_date() {
        $date = new DateTime();
        return $date->format("Y-m-d H:i:s");
    }

    private function get_post_image($date) {
        $image = $_FILES["post_image"];
        $save_date = date("d_m_Y_H_i_s", strtotime($date));
        $target_file_return = "./assets/images/post_images/" . $save_date . "_" . strtolower($image["name"]);
        $target_file = "../assets/images/post_images/" . $save_date . "_" . strtolower($image["name"]);
        $moved = move_uploaded_file($_FILES["post_image"]["tmp_name"], $target_file);
        if ($moved)
            return $target_file_return;
        else
            return "";
    }

}
