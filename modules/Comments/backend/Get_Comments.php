/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php

class Get_Comments {

    public function Comments_Count($post) {
        $count = array();
        $id = intval($post);
        $path = "./post_data/posts/post_$id.xml";
        $xml = simplexml_load_file($path);
        $comments = $xml->comments;
        foreach ($comments->comment as $com) {
            if ($com->valid == 1) {
                array_push($com, $count);
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
                    $date = $com->comment_date;
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

}
