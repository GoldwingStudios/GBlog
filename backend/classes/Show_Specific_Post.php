<?php

class Show_Post {

    var $id, $title, $text, $date, $visible;

    public function GetSpecificPost($ID) {
        $set_up_post = "";
        if (is_numeric($ID)) {
            $id_ = intval($ID);
            $id = (string) $ID;
            $this->get_post_data($id_);
            if (!empty($this->id) && !empty($this->title) && !empty($this->text) && !empty($this->date) && !empty($this->visible)) {
                $c_post_data = $this->clean_up();
                $set_up_post = $this->set_up($c_post_data);
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
            $stmt->bind_result($this->id, $this->title, $this->text, $this->date, $this->visible, $this->tags, $this->post_image_path);
            $stmt->fetch();
        }
        $connection->close();
    }

    private function clean_up() {
        $post = Array();
        $this->title = htmlentities($this->title, ENT_COMPAT, "UTF-8");
        $this->text = $this->prepare_text($this->text);
        $this->date = htmlentities($this->prepare_date($this->date), ENT_COMPAT, "UTF-8");
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
        if (!empty($this->post_image_path)) {
            $post_image = '<img class="blog__entry__image__spec" src="' . $this->post_image_path . '"/><br><br>';
        } else {
            $post_image = "";
        }

        $output_post = ''
                . $post_image
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

        $value = str_replace("\r\n", "<br>", $value);
        $value = str_replace("_", "<br>", $value);

        //Links
        $substring_count = substr_count($value, 'http');
        $pos = 0;
        for ($i = 0; $i < $substring_count; $i++) {
            $link_start = strpos($value, 'http', $pos);
            $link_length = (strpos($value, " ", $link_start) - $link_start);
            $link = substr($value, $link_start, $link_length);
            $link_url = htmlentities($link, ENT_COMPAT, "UTF-8");
            $link_text = $this->prepare_link($link);
            $output_link = '<a href="' . $link_url . '">' . $link_text . '</a>';
            $value = str_replace($link, $output_link, $value);
            $pos = $link_start + $link_length;
        }
        return $value;
    }

    private function prepare_date($date) {
        $date_object = date("d.m.Y, H:i:s", strtotime($date));
        return $date_object;
    }

    private function prepare_link($link) {
        $return_link = substr($link, 3 + strpos($link, '://'));
        $return_link = str_replace("www.", "", $return_link);
        return $return_link;
    }

}
