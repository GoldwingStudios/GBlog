<?php

class Show_Post {

    var $id, $title, $text, $date, $visible;

    function get_spec_post($id) {
        $set_up_post = "";
        if (is_numeric($id)) {
            $id_ = intval($id);
            $id = (string) $id;
            $this->get_post_data($id_);
            if (!empty($this->id) && !empty($this->title) && !empty($this->text) && !empty($this->date) && !empty($this->visible)) {
                $c_post_data = $this->clean_up();
                $set_up_post = $this->set_up($c_post_data);
            } else {
//                $set_up_post = '<script>window.location.replace("index.php");</script>';
            }
        } else {
            $set_up_post = '<script>window.location.replace("index.php");</script>';
        }
        echo '<div class="blog__fullentry">';
        echo $set_up_post;
        echo '</div>';
        include "modules/Comments/frontend/Comment_Section.php";
    }

    private function get_post_data($id_) {
        $connection = new sql_connect();
        $connection = $connection->mysqli();

        $sql_string = "SELECT * FROM blog_posts WHERE post_id=? ";

        if ($stmt = $connection->prepare($sql_string)) {
            $stmt->bind_param("i", $id_);
            $stmt->execute();
            $stmt->bind_result($id, $title, $text, $date, $visible, $tags);
            $stmt->fetch();
            $this->id = $id;
            $this->title = $title;
            $this->text = $text;
            $this->date = $date;
            $this->visible = $visible;
            $this->tags = $tags;
        }
        $connection->close();
    }

    private function clean_up() {
        $post = Array();
        $this->title = htmlentities($this->title, ENT_COMPAT, "UTF-8");
        $this->text = $this->prepare_text(htmlentities($this->text, ENT_COMPAT, "UTF-8"));
        $this->date = htmlentities($this->date, ENT_COMPAT, "UTF-8");
        $this->visible = htmlentities($this->visible, ENT_COMPAT, "UTF-8");

        $tags = htmlentities($this->tags, ENT_COMPAT, "UTF-8");
        $tag_str = "";
        $tags = explode(",", $tags);
        $tags = str_replace(" ", "", $tags);
        foreach ($tags as $t) {
            if ($t != "") {
                $tag_url = $this->switch_from_special($t);
                $tag_str .= '<a href="index.php?tag=' . $tag_url . '">' . $t . '</a>';
            }
        }
        $this->tags = $tag_str;
    }

    private function set_up() {
        $output_post = ''
                . '<h1 class="blog__fullentry__title">' . $this->title . '</h1>'
                . '<span class="blog__fullentry__date">' . $this->date . '</span>'
                . '<p class="blog__fullentry__text">' . $this->text . '</p>'
                . '<div class="blog__fullentry__tags">'
                . $this->tags
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
