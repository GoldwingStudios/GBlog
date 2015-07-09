<?php

class Blog_Posts {

    function get_blog_posts() {
        $sql = new sql_connect();
        $sql_str = "SELECT * FROM blog_posts WHERE post_visible='1' ORDER BY post_date DESC ";
        $posts = $sql->return_array($sql_str);
        foreach ($posts as $p) {
            $id = $this->generate_blog_id($p["post_id"]);
            $date = new DateTime($p["post_date"]);
            $date = $date->format("d.m.Y, H:i");
            $title = htmlentities($p["post_title"], ENT_COMPAT, "UTF-8");
            $text = htmlentities($this->get_preview($p["post_text"]), ENT_COMPAT, "UTF-8");
            $text = str_replace("_", " ", $text);
            $text = str_replace("[a]", " ", $text);
            $text = str_replace("[/a]", " ", $text);
            $text = str_replace("http://", " ", $text);
            echo ''
            . '<a class="blog__entry" href="index.php?post=' . $id . '">'
            . '<div class="blog__entry__header"><h2>' . $title . '</h2><span class="blog__entry__date">' . $date . '</span></div>'
            . '<p>' . $text . '</p>'
            . '</a>';
        }
    }

    private function generate_blog_id($id) {
        $return = $id;
        while (strlen($return) <= 3) {
            $return = "0" . $return;
        }
        return $return;
    }

    private function get_preview($text) {
        $steps = 100;
        $last_space = $text[$steps];
        if (strlen($text) < $steps) {
            return $text;
        } else {
            if ($last_space == " ") {
                return substr($text, 0, $steps);
            } else {
                while ($steps <= strlen($text)) {
                    $steps = $steps + 1;
                    $x = $text[$steps];
                    if ($text[$steps] == " ") {
                        return substr($text, 0, $steps);
                    }
                }
                return substr($text, 0, $steps);
            }
        }
    }

}
