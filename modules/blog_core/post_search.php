<?php

class Post_Search {

    function search_for_posts($search_tag) {
        if ($search_tag === "") {
            return;
        }
        if (!$this->hashtml($search_tag)) {
            $posts_with_tag = array();
            $search_tags = explode(" ", $search_tag);
            $posts = $this->get_posts($search_tags);
            return $posts;
        }
    }

    private function hashtml($string) {
        if ($string != strip_tags($string))
            return true;
        else
            return false;
    }

    private function get_posts($search_tags) {
        $posts = array();
        if ($search_tags == "") {
            return;
        }
        $sql_connect = new sql_connect();
        $connection = $sql_connect->mysqli();
        $variable_string = "";

        $get_posts = "SELECT * FROM blog_posts WHERE ";
        $additional_string = "";
        $variables = array();
        $variables[] = &$variable_string;
        foreach ($search_tags as $tag) {
            if ($additional_string == "") {
                $variable_string .= "sss";
                $additional_string .= "post_title LIKE ? OR post_text LIKE ? OR post_tags LIKE ? ";
                $variables[] = "%" . $tag . "%";
                $variables[] = "%" . $tag . "%";
                $variables[] = "%" . $tag . "%";
            } else {
                $variable_string .= "sss";
                $additional_string .= "OR post_title LIKE ? OR post_text LIKE ? OR post_tags LIKE ? ";
                $variables[] = "%" . $tag . "%";
                $variables[] = "%" . $tag . "%";
                $variables[] = "%" . $tag . "%";
            }
        }
        $get_posts = $get_posts . $additional_string;

        if ($stmt = $connection->prepare($get_posts)) {
//            foreach ($variables as $var) {
//                $stmt->bind_param($var);
//            }
            call_user_func_array(array($stmt, 'bind_param'), $this->refs($variables));
            $stmt->execute();
//            $stmt->bind_result($id, $title, $text, $date, $visible, $tags);
//            $x = $stmt->fetch();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $row = str_replace("_", " ", $row);
                $row = str_replace("[a]", " ", $row);
                $row = str_replace("[/a]", " ", $row);
                $row = str_replace("http://", " ", $row);
                $posts[] = $row;
            }
        }
        return $posts;
    }

    function refs(array $ar) {
        $r = array();
        foreach ($ar as $k => $v) {
            $r[$k] = &$ar[$k];
        }
        return $r;
    }

}
