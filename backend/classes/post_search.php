<?php

class Post_Search {

    public function __construct() {
        $this->Connection = new DB_Connect();
        $this->used_aliases = array();
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

        $source_string = "";

        $variables = array();
        $i = 0;
//        $search_tags = array_reverse($search_tags);
        foreach ($search_tags as $tag) {
            $random_string = $this->generateRandomString();
            if ($tag != "" && $tag != " ") {
                if ($source_string != "") {
                    $tag_1 = ":TAG" . $i++;
                    $tag_2 = ":TAG" . $i++;
                    $tag_3 = ":TAG" . $i++;
                    $variables[$tag_1] = "%$tag%";
                    $variables[$tag_2] = "%$tag%";
                    $variables[$tag_3] = "%$tag%";
                    $get_posts = "SELECT * FROM ($source_string) AS $random_string WHERE post_title LIKE $tag_1 OR post_text LIKE $tag_2 OR post_tags LIKE $tag_3 ";
                    $source_string = $get_posts;
                } else {
                    $tag_1 = ":TAG" . $i++;
                    $tag_2 = ":TAG" . $i++;
                    $tag_3 = ":TAG" . $i++;
                    $source_string = "SELECT * FROM blog_posts WHERE post_title LIKE $tag_1 OR post_text LIKE $tag_2 OR post_tags LIKE $tag_3 ";
                    $variables[$tag_1] = "%$tag%";
                    $variables[$tag_2] = "%$tag%";
                    $variables[$tag_3] = "%$tag%";
                }
            }
        }

        if ($get_posts == "") {
            $get_posts = $source_string;
        }
        $posts = $this->Connection->Return_PDO_Array($get_posts, $variables);
        foreach ($posts as $key => $post) {
            $post["post_title"] = $this->replace($post["post_title"]);
            $post["post_text"] = $this->replace($post["post_text"]);
            $post["post_tags"] = $this->replace($post["post_tags"]);
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

    private function generateRandomString() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $loop = false;
        do {
            $loop = false;
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            if (in_array($randomString, $this->used_aliases)) {
                $loop = true;
            }
        } while ($loop);

        return $randomString;
    }

}
