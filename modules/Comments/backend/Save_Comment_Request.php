<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Save_Comment_Request {

    public function Write_Comment($post_id) {
        $connection = new sql_connect();
        $connection = $connection->mysqli();
        $post_id = intval($post_id);
        $comment_name = filter_input(INPUT_POST, "user_name");
        $comment_mail = $this->check_mail(filter_input(INPUT_POST, "user_mail")) ? null : filter_input(INPUT_POST, "user_mail");
        $comment_text = filter_input(INPUT_POST, "user_text");
        $comment_date = $this->get_date();
        $comment_valid = 0;

        if ($comment_mail != null) {
            $sql_str = "INSERT INTO blog_comments (`post_id`, `comment_name`, `comment_mail`, `comment_text`, `comment_date`, `comment_valid`) VALUES (?, ?, ?, ?, ?, ?)";

            if ($stmt = $connection->prepare($sql_str)) {
                $stmt->bind_param("issssi", $post_id, $comment_name, $comment_mail, $comment_text, $comment_date, $comment_valid);
                $return = $stmt->execute(); //returns true if succeed and otherwise false
            }
            $connection->close();
            return $return;
        }
    }

    private function get_date() {
        $date = new DateTime();
        return $date->format("Y-m-d H:i:s");
    }

    function check_mail($mail) {
        return preg_match("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$", $mail);
    }

}
