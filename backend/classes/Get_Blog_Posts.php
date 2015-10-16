<?php

class Blog_Posts {

    public function __construct() {
        $this->General_Functions = new General_Functions();
    }

    /*
     * Get and output all blog posts
     */

    public function get_blog_posts() {
        $DB_Connect = new DB_Connect();
        $Sql_String = "SELECT * FROM blog_posts WHERE post_visible='1' ORDER BY post_date DESC ";
        $Posts = $DB_Connect->Return_PDO_Array($Sql_String);
        foreach ($Posts as $Post) {
            $this->output_post($Post);
        }
    }

    /*
     * Function which is used to output all posts
     */

    private function output_post($Post) {
        $Post_ID = $this->General_Functions->generate_blog_id($Post["post_title"]);
        $Post_Date = new DateTime($Post["post_date"]);
        $Post_Date_Formatted = $Post_Date->format("d.m.Y, H:i");
        $Post_Title = htmlentities($Post["post_title"], ENT_COMPAT, "UTF-8");
        $Post_Text = htmlentities($this->get_preview($Post["post_text"]), ENT_COMPAT, "UTF-8");
        $Post_Text = str_replace("_", " ", $Post_Text);
        $Post_Text = str_replace("[a]", "", $Post_Text);
        $Post_Text = str_replace("[/a]", "", $Post_Text);
        $Post_Text = str_replace("http://", "", $Post_Text);
        $Post_Text = str_replace("https://", "", $Post_Text);
        if (!empty($Post["post_image_path"])) {
            $Post_Image = '<div class="blog__entry__image" style="background-image: url(\'' . $Post["post_image_path"] . '\')"></div><br><br>';
        } else {
            $Post_Image = "";
        }

        echo '<a class="blog__entry" href="index.php?post=' . $Post_ID . '">'
        . '<div class="blog__entry__header">'
        . $Post_Image
        . '<h2>' . $Post_Title . '</h2><span class="blog__entry__date">' . $Post_Date_Formatted . '</span></div>'
        . '<p>' . $Post_Text . ' [...]</p>'
        . '</a>';
    }

    /*
     * Generates a post preview of the post for the user
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

}
