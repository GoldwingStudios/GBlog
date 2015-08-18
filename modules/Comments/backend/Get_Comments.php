<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Get_Comments {

    public function __construct() {
        $this->Connection = new DB_Connect();
    }

    public function Comments_Count($post) {
        $post_id = intval($post);

        if (isset($post_id)) {
            $SQL_String = "SELECT * FROM blog_comments WHERE post_id = :Post_ID AND comment_valid = 1";
            $Parameters = array(":Post_ID" => $post_id);
            $comments = $this->Connection->Return_PDO_Array($SQL_String, $Parameters);
        }
        return count($comments);
    }

    public function Show_Comments($post) {
        $id = intval($post);

        $SQL_String = "SELECT * FROM blog_comments WHERE post_id = :Post_ID AND comment_valid = 1";
        $Parameters = array(":Post_ID" => $id);
        $comments = $this->Connection->Return_PDO_Array($SQL_String, $Parameters);

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
