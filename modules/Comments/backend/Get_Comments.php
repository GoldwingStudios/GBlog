<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Get_Comments {

    public function Comments_Count($post) {
        $connection = new sql_connect();
        $connection = $connection->mysqli();
        $post_id = intval($post);

        if (isset($post_id)) {
            $sql_str = "SELECT * FROM blog_comments WHERE post_id = ? AND comment_valid = 1";
            if ($stmt = $connection->prepare($sql_str)) {
                $stmt->bind_param("i", $post_id);
                $stmt->execute();
                $return = $stmt->get_result();
                while ($row = $return->fetch_assoc()) {
                    $comments[] = $row;
                }
            }
        }
        return count($comments);
    }

    public function Show_Comments($post) {
        $connection = new sql_connect();
        $connection = $connection->mysqli();
        $id = intval($post);
        $sql_str = "SELECT * FROM blog_comments WHERE `post_id` = ?";

        if ($stmt = $connection->prepare($sql_str)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $return = $stmt->get_result();
            while ($row = $return->fetch_assoc()) {
                $comments[] = $row;
            }
        }
        $connection->close();

        foreach ($comments as $comment) {
            if ($comment["comment_valid"] == 1) {
                if (!$this->check($comment["comment_name"]) && !$this->check($comment["comment_text"])) {
                    $name = $comment["comment_name"];
                    $date = $this->get_date($comment["comment_date"]);
                    $text = $comment["comment_text"];
                    echo '<div class="comment">'
                    . '<div class="comment__data"><h1 class="comment__name">' . $name . '</h1>'
                    . '<span class="comment__date">' . $date . '</span></div>'
                    . '<p class="comment__text">' . $text . '</p>'
                    . '</div>';
                }
            }
        }
    }

    private function get_date($date) {
        $date = new DateTime($date);
        return $date->format("d.m.Y, H:i");
    }

    private function check($input) {
        if (!$html = $this->Check_Input_For_Html($input)) {
            if (!$sql = $this->Check_Input_For_Sql($input)) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    private function Check_Input_For_Html($string) {
        if ($string != strip_tags($string)) {
            return true;
        } else {
            return false;
        }
    }

    private function Check_Input_For_Sql($string) {
        $array = array("SELECT", "UPDATE", "DELETE");
        if (in_array($string, $array)) {
            return true;
        } else {
            return false;
        }
    }

}
