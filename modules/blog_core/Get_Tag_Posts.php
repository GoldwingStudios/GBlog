<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Get_Tag_Posts {

    function show_posts_for_tag($tag) {
        if (!$this->hashtml($tag)) {
            $get_specific_tag_posts = $this->get_post_for_tag($tag);
            foreach ($get_specific_tag_posts as $p) {
                $id = $this->generate_blog_id($p[0]["post_id"]);
                $date = new DateTime($p[0]["post_date"]);
                $date = $date->format("d.m.Y, H:i");
                $title = htmlentities($p[0]["post_title"], ENT_COMPAT, "UTF-8");
                $text = htmlentities($p[0]["post_text"], ENT_COMPAT, "UTF-8");
                $text = str_replace("_", " ", $text);
                echo '<a class="blog_link" href="index.php?post=' . $id . '">'
                . '<div class="blog_post">'
                . '<div class="post_title"><span class="post_title_t">' . $title . '</span></div>'
                . '<div class="post_date"><span class="post_date_text">' . $date . '</span></div>'
                . '<div class="post_text"><span class="post_text_t">' . $text . ' [...]</span></div>'
                . '</div>'
                . '</a>';
            }
        }
    }

    private function get_post_for_tag($tag) {
        if (!$this->hashtml($tag)) {
            $posts_with_tag = array();
            $posts = $this->get_posts();

            foreach ($posts as $p) {
                $x = stripos((string) $p["post_tags"], $tag);
                if ($x == (int) 0) {
                    $x++;
                }
                if ($x != FALSE) {
                    $result[] = $p;
                    $posts_with_tag[] = $result;
                }
            }
            return $posts_with_tag;
        }
    }

    private function get_posts() {
        $sql_connect = new sql_connect();

        $get_posts = "SELECT * FROM blog_posts";
        $posts = $sql_connect->return_array($get_posts);
        return $posts;
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

    function output_most_related_tags() {
        $posts = $this->get_posts();
        $tags_and_count = array();

        echo "<h3>Tag-Suche</h3>";
        foreach ($posts as $p) {
            if ($p["post_visible"] == 1) {
                $tags_ = explode(",", $p["post_tags"]);
                $tags_ = str_replace(" ", "", $tags_);
                foreach ($tags_ as $t) {
                    $tags_and_count[$t] += 1;
                }
            }
        }
        asort($tags_and_count, SORT_NUMERIC);
        $tags_and_count = array_reverse($tags_and_count, TRUE);
        $i = 1;
        foreach ($tags_and_count as $key => $value) {
            if ($i <= 5 && $key != "") {
                echo '<a href="?tag=' . $key . '">' . $i . ". " . $key . "</a><br/>";
                $i++;
            }
        }
    }

    private function hashtml($string) {
        if ($string != strip_tags($string))
            return true;
        else
            return false;
    }

}
