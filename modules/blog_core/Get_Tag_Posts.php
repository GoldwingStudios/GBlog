/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php

class Get_Tag_Posts {

    private function get_post_for_tag($tag) {
        if (!$this->hashtml($tag)) {
            $posts_with_tag = array();
            $path = "post_data/posts/*.xml";
            $posts = glob($path);

            $i = 0;
            foreach ($posts as $p) {
                $post = simplexml_load_file($p);
                $x = strpos($post->tags, $tag);
                if ($x == (int) 0) {
                    $x++;
                }
                if ($x != FALSE) {
                    $result = array();
                    $filename = explode("_", $p);
                    $id = explode(".", $filename[2]);
                    $id = $id[0];

                    $sql = new sql_connect();
                    $sql_str = "SELECT * FROM blog_posts WHERE visible='1' AND id=? ORDER BY date DESC ";
                    $connection = $sql->mysqli();
                    $return = 0;

                    if ($stmt = $connection->prepare($sql_str)) {
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $stmt->bind_result($id_, $post_title, $post_preview, $date, $visible);
                        $x = 0;
                        while ($stmt->fetch()) {
                            $result[$x]["id"] = $id_;
                            $result[$x]["post_title"] = $post_title;
                            $result[$x]["post_preview"] = $post_preview;
                            $result[$x]["date"] = $date;
                            $result[$x]["visible"] = $visible;
                        }
                    }

                    $posts_with_tag[$i]["xml"] = $post;
                    $posts_with_tag[$i]["sql"] = $result;
                    $connection->close();
                }
                $i++;
            }
            return $posts_with_tag;
        }
    }

    function show_posts_for_tag($tag) {
        if (!$this->hashtml($tag)) {
            $get_specific_tag_posts = $this->get_post_for_tag($tag);
            foreach ($get_specific_tag_posts as $p) {
                $id = $this->generate_blog_id($p["sql"][0]["id"]);
                $date = new DateTime($p["sql"][0]["date"]);
                $date = $date->format("d.m.Y, H:i");
                $title = htmlentities($p["sql"][0]["post_title"], ENT_COMPAT, "UTF-8");
                $text = htmlentities($p["sql"][0]["post_preview"], ENT_COMPAT, "UTF-8");
                $text = str_replace("_", " ", $text);
                echo '<a class="blog_link" href="index.php?post=' . $id . '">'
                . '<div class="blog_post">'
                . '<div class="post_title"><span class="post_title_t">' . $title . '</span></div>'
                . '<div class="post_date"><span class="post_date_text">' . $date . '</span></div>'
                . '<div class="post_text"><span class="post_text_t">' . $text . ' ...</span></div>'
                . '</div>'
                . '</a>';
            }
        }
    }

    private function generate_blog_id($id) {
        $return = $id;
        while (strlen($return) <= 3) {
            $return = "0" . $return;
        }
        return $return;
    }

    function output_most_related_tags() {
        $tags_and_count = array();
        $path = "post_data/posts/*.xml";
        $posts = glob($path);

        echo "<h3>Tag-Suche</h3>";
        foreach ($posts as $p) {
            $post = simplexml_load_file($p);
            if ($post->visible == 1) {

                $tags_ = explode(",", $post->tags);
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
