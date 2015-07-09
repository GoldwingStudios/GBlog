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
        $count = array();
        $id = intval($post);
        $path = "./post_data/posts/post_$id.xml";
        $xml = simplexml_load_file($path);
        $comments = $xml->comments;
        foreach ($comments->comment as $com) {
            if ($com->valid == 1) {
                array_push($count, $com);
            }
        }
        return count($count);
    }

    public function Show_Comments($post) {
        $id = intval($post);
        $path = "./post_data/posts/post_$id.xml";
        $xml = simplexml_load_file($path);
        $comments = $xml->comments;
        foreach ($comments as $comment) {
            foreach ($comment as $com) {
                if ($com->valid == 1) {
                    if (!$this->check($com->comment_name) && !$this->check($com->comment_text)) {
                        $name = $com->comment_name;
                        $date = $this->get_date($com->comment_date);
                        $text = $com->comment_text;
                        echo '<div class="comment">'
                        . '<div class="comment__data"><h1 class="comment__name">' . $name . '</h1>'
                        . '<span class="comment__date">' . $date . '</span></div>'
                        . '<p class="comment__text">' . $text . '</p>'
                        . '</div>';
                    }
                }
            }
        }
    }

    private function get_date($date) {
        $date = new DateTime($date);
        return $date->format("d.m.Y H:i");
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
