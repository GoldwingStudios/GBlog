<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Get_Tag_Posts {

    public function __construct() {
        $this->Connection = new DB_Connect();
        $this->General_Functions = new General_Functions();
    }

    /*
     * Output all Posts for a specific post
     */

    public function Show_Tagged_Posts($Tag) {
        if (!$this->hashtml($Tag)) {
            $Tagged_Posts = $this->gettaggedposts($Tag);
            foreach ($Tagged_Posts as $Post) {
                $this->writetofrontend($Post);
            }
        }
    }

    /*
     * Output Tags for all posts ranked by the appearance in all post
     */

    public function Show_Related_Tags() {
        $tags_and_count = array();
        $this->get_Tags($tags_and_count);
        asort($tags_and_count, SORT_NUMERIC);
        $tags_and_count = array_reverse($tags_and_count, TRUE);
        $i = 1;
        foreach ($tags_and_count as $key => $value) {
            if ($i <= 5 && $key != "") {
                echo '<li><a href="?tag=' . $key . '">' . $key . "</a></li>";
                $i++;
            } else if ($i > 5 || $key == "") {
                break;
            }
        }
    }

    /*
     * Function to write the Tagged Posts to the Frontend
     */

    private function writetofrontend($Post) {
        $Post_ID = $this->General_Functions->Generate_Blog_ID($Post["post_title"]);
        $Post_Date = new DateTime($Post["post_date"]);
        $Post_Date_Formatted = $Post_Date->format("d.m.Y, H:i");
        $Post_Title = htmlentities($Post["post_title"], ENT_COMPAT, "UTF-8");
        $Post_Text = str_replace("_", " ", $this->get_preview($Post["post_text"], ENT_COMPAT, "UTF-8"));
        if (!empty($Post["post_image_path"])) {
            $Post_Image = '<div class="blog__entry__image" style="background-image: url(\'' . $Post["post_image_path"] . '\'"></div><br><br>';
        } else {
            $Post_Image = "";
        }
        $Output_String = ''
                . '<a class="blog__entry" href="index.php?post=' . $Post_ID . '">'
                . '<div class="blog__entry__header">'
                . $Post_Image
                . '<h2>' . $Post_Title . '</h2><span class="blog__entry__date">' . $Post_Date_Formatted . '</span></div>'
                . '<p>' . $Post_Text . ' [...]</p>'
                . '</a>';
        echo $Output_String;
    }

    /*
     * Get Tags from Posts
     */

    private function get_Tags(&$tags_and_count) {
        $Posts = $this->get_posts();
        foreach ($Posts as $Post) {
            if ($Post["post_visible"] == 1) {
                $Tags = explode(",", str_replace(" ", "", $Post["post_tags"]));

                foreach ($Tags as $Tag) {
                    $t = strtolower($Tag);
                    $tags_and_count[$t] += 1;
                }
            }
        }
    }

    /*
     * Get the specific Posts for a tag
     */

    private function gettaggedposts($tag) {
        if (!$this->hashtml($tag)) {
            $posts_with_tag = array();
            $posts = $this->get_posts();

            foreach ($posts as $p) {
                $x = stripos((string) $p["post_tags"], $tag);
                if ($x == (int) 0) {
                    $x++;
                }
                if ($x != FALSE) {
                    $posts_with_tag[] = $p;
                }
            }
            return $posts_with_tag;
        }
    }

    /*
     * Function to create a Posts preview to show the user what is in the post
     */

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

    /*
     * Function to get all posts from the Database
     */

    private function get_posts() {
        $get_posts = "SELECT * FROM blog_posts ORDER BY post_date DESC";
        $posts = $this->Connection->Return_PDO_Array($get_posts);
        return $posts;
    }

    /*
     * Function to generate a posts-ID which is visible in the URL
     */

    private function generate_blog_id($id) {
        $return = $id;
        while (strlen($return) <= 3) {
            $return = "0" . $return;
        }
        return $return;
    }

    /*
     * Function to check if a string contains html-tags, which could contains XSS-Content
     */

    private function hashtml($string) {
        if ($string != strip_tags($string))
            return true;
        else
            return false;
    }

}
