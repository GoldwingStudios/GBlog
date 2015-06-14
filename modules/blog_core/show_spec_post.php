<?php

class Show_Post {

    function get_spec_post($id) {
        $set_up_post = "";
        if (is_numeric($id)) {
            $id_ = intval($id);
            $id = (string) $id;
            $post_data = $this->get_post_data($id_);
            if (!empty($post_data)) {
                $c_post_data = $this->clean_up($post_data);
                $set_up_post = $this->set_up($c_post_data);
            } else {
                $set_up_post = '<script>window.location.replace("index.php");</script>';
            }
        } else {
            $set_up_post = '<script>window.location.replace("index.php");</script>';
        }
        echo '<div class="blog_post_container">';
        echo $set_up_post;
        include "modules/Comments/frontend/Comment_Section.php";
        echo '</div>';
    }

    private function get_post_data($id) {
        $post = simplexml_load_file("post_data/posts/post_" . $id . ".xml");
        return $post;
    }

    private function clean_up($post_data) {

        $post = Array();
        foreach ($post_data as $key => $value) {

            $value = htmlentities($value, ENT_COMPAT, "UTF-8");
            if ($key == "title") {
                $value = str_replace("ä", "&auml;", $value);
                $value = str_replace("ö", "&ouml;", $value);
                $value = str_replace("ü", "&uuml;", $value);
                $value = str_replace("ß", "&szlig;", $value);
            }
            if ($key == "text") {
                $value = $this->prepare_text($value);
            }
            if ($key == "tags") {
                $tag_str = "";
                $tags = explode(",", $value);
                $tags = str_replace(" ", "", $tags);
                foreach ($tags as $t) {
                    $tag_url = $this->switch_from_special($t);
                    if (empty($tag_str)) {
                        $tag_str = '<a href="index.php?tag=' . $tag_url . '">' . $t . '</a>';
                    } else {
                        $tag_str .= ', <a href="index.php?tag=' . $tag_url . '">' . $t . '</a>';
                    }
                }
                $value = $tag_str;
            }
            $post[$key] = $value;
        }
        return $post;
    }

    private function set_up($c_post_data) {
        $output_post = '<div class="blog_post_single">'
                . '<div class="post_title"><span class="post_title_t">' . $c_post_data["title"] . '</span></div>'
                . '<div class="post_date"><span class="post_date_text">' . $c_post_data["date"] . '</span></div>'
                . '<div class="post_text"><span class="post_text_t">' . $c_post_data["text"] . '</span></div>'
                . '<div class="post_tags">'
                . 'Tags: ' . $c_post_data["tags"]
                . '</div>'
                . '</div>';
        return $output_post;
    }

    private function switch_from_special($str) {
        $str = str_replace("&auml;", "ae", $str);
        $str = str_replace("&ouml;", "oe", $str);
        $str = str_replace("&uuml;", "ue", $str);
        $str = str_replace("&szlig;", "ss", $str);
        return $str;
    }

    private function prepare_text($value) {


        //Umlaute
        $value = str_replace("_", "<br/>", $value);
        $value = str_replace("ä", "&auml;", $value);
        $value = str_replace("ö", "&ouml;", $value);
        $value = str_replace("ü", "&uuml;", $value);
        $value = str_replace("ß", "&szlig;", $value);


        //Links

        while (strpos($value, '[a]') !== false) {
            $link_start_pos = strpos($value, "[a]");
            $link_end_pos = strpos($value, "[/a]");
            $link = substr($value, $link_start_pos, (($link_end_pos - $link_start_pos) + 4));
            $link_str = str_replace("[a]", "", $link);
            $link_str = str_replace("[/a]", "", $link_str);
            $value = str_replace($link, '<a class="blog_link_single" target="_blank" href="http://' . $link_str . '">' . $link_str . '</a>', $value);
        }




        return $value;
    }

}
