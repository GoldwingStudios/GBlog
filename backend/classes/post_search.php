<?php

class Post_Search {

    public function __construct() {
        $this->Connection = new DB_Connect();
    }

    public function search_for_posts($search_tag) {
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

        $additional_string = "";
        $variables = array();
        $i = 0;
        foreach ($search_tags as $tag) {
            if ($additional_string == "") {
                $tag_1 = ":TAG" . $i++;
                $tag_2 = ":TAG" . $i++;
                $tag_3 = ":TAG" . $i++;
                $additional_string .= "post_title LIKE $tag_1 OR post_text LIKE $tag_2 OR post_tags LIKE $tag_3 ";
                $variables[$tag_1] = "%" . $tag . "%";
                $variables[$tag_2] = "%" . $tag . "%";
                $variables[$tag_3] = "%" . $tag . "%";
            } else {
                $tag_1 = ":TAG" . $i++;
                $tag_2 = ":TAG" . $i++;
                $tag_3 = ":TAG" . $i++;
                $additional_string .= "OR post_title LIKE $tag_1 OR post_text LIKE $tag_2 OR post_tags LIKE $tag_3 ";
                $variables[$tag_1] = "%" . $tag . "%";
                $variables[$tag_2] = "%" . $tag . "%";
                $variables[$tag_3] = "%" . $tag . "%";
            }
        }
        $get_posts = "SELECT * FROM blog_posts WHERE " . $additional_string;

        $posts = $this->Connection->Return_PDO_Array($get_posts, $variables);
        foreach ($posts as $key => $post) {
            $post["post_title"] = htmlentities($this->replace($post["post_title"]));
            $post["post_text"] = htmlentities($this->replace($post["post_text"]));
            $post["post_tags"] = htmlentities($this->replace($post["post_tags"]));
            $posts[$key] = $post;
        }
        return $posts;
    }

    public function refs(array $ar) {
        $r = array();
        foreach ($ar as $k => $v) {
            $r[$k] = &$ar[$k];
        }
        return $r;
    }

    private function replace($String) {
        $String = str_replace("_", " ", $String);
        $String = str_replace("[a]", " ", $String);
        $String = str_replace("[/a]", " ", $String);
        $String = str_replace("http://", " ", $String);
        return $String;
    }

}
