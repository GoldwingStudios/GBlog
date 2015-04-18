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
                    $name = $com->comment_name;
                    $date = $this->get_date($com->comment_date);
                    $text = $com->comment_text;
                    echo '<div class="post_comment">'
                    . '<div class="post_comment_name">'
                    . '<span>' . $name . '</span>'
                    . '</div>'
                    . '<div class="post_comment_date">'
                    . '<span>' . $date . '</span>'
                    . '</div>'
                    . '<div class="post_comment_text">'
                    . '<span>' . $text . '</span>'
                    . '</div>'
                    . '</div>';
                }
            }
        }
    }

    private function get_date($date) {
        $date = new DateTime($date);
        return $date->format("d.m.Y H:i");
    }

}
