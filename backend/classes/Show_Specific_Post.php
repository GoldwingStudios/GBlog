<?php

class Show_Post {

    var $id, $title, $text, $date, $visible;

    public function __construct() {
        $this->Connection = new DB_Connect();
    }

    public function GetSpecificPost($ID) {
        $set_up_post = "";
        if (is_numeric($ID)) {
            $id_ = intval($ID);
            $id = (string) $ID;
            $this->get_post_data($id_);
            if (!empty($this->Post_Data)) {
                $this->clean_up();
                $set_up_post = $this->set_up();
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

        $SQL_String = "SELECT * FROM blog_posts WHERE post_id = :Post_ID ";
        $Parameter = array(":Post_ID" => $id_);

        $this->Post_Data = $this->Connection->Return_PDO_Array($SQL_String, $Parameter);
    }

    private function clean_up() {
        $this->Title = htmlentities($this->Post_Data[0]["post_title"], ENT_COMPAT, "UTF-8");
        $this->Text = $this->prepare_text($this->Post_Data[0]["post_text"]);
        $this->Date = htmlentities($this->prepare_date($this->Post_Data[0]["post_date"]), ENT_COMPAT, "UTF-8");
        $this->Visible = htmlentities($this->Post_Data[0]["post_visible"], ENT_COMPAT, "UTF-8");

        $tags = htmlentities($this->Post_Data[0]["post_tags"], ENT_COMPAT, "UTF-8");
        $tag_str = "";
        $tags = explode(",", $tags);
        $tags = str_replace(" ", "", $tags);
        foreach ($tags as $t) {
            if ($t != "") {
                $tag_url = $this->switch_from_special($t);
                $tag_str .= '<a href="index.php?tag=' . $tag_url . '">' . $t . '</a>';
            }
        }
        $this->Tags = $tag_str;
    }

    private function set_up() {
        if (!empty($this->Post_Data[0]["post_image_path"])) {
            $post_image = '<img class="blog__entry__image__spec" src="' . $this->Post_Data[0]["post_image_path"] . '"/><br><br>';
        } else {
            $post_image = "";
        }

        $output_post = ''
                . $post_image
                . '<h1 class="blog__fullentry__title">' . $this->Title . '</h1>'
                . '<span class="blog__fullentry__date">' . $this->Date . '</span>'
                . '<p class="blog__fullentry__text">' . $this->Text . '</p>'
                . '<div class="blog__fullentry__tags">'
                . $this->Tags
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
