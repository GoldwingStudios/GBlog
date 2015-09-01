<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Post_Edit {
    /*
     * 
     * Constructer Function to load PDO-Connection class
     */

    public function __construct() {
        $this->Connection = new DB_Connect();
        $this->inputs = 0;
    }

    /*
     * 
     * Function to load a existing Post for Editing
     */

    public function Load_Post_For_Edit($id) {
        $Post_ID = intval($id);

        $Sql_Query = "SELECT * FROM blog_posts WHERE post_id = :Post_ID ";
        $Parameter = array(":Post_ID" => $Post_ID);
        $post = $this->Connection->Return_PDO_Row($Sql_Query, $Parameter);
        return $post;
    }

    /*
     * 
     * Function to edit a Post and re-set the Post-Data (e.g. Title, Text, Tags)
     */

    public function Recreate_Post() {
        $Post_ID = $this->check_input(intval(filter_input(INPUT_GET, "id")), "id");
        $Post_Title = $this->check_input(filter_input(INPUT_POST, "post_title"), "post_title");
        $Post_Date = $this->date($this->check_input(filter_input(INPUT_POST, "post_date_calendar"), "post_date_calendar"), $this->check_input(filter_input(INPUT_POST, "post_date_time"), "post_date_time"));
        $Post_Text = $this->check_input(filter_input(INPUT_POST, "post_text"), "post_text");
        $Post_Tags = $this->check_input(filter_input(INPUT_POST, "post_tags"), "post_tags");
        $Post_Visible = $this->check_input(filter_input(INPUT_POST, "post_visible"), "post_visible");

        if ($this->inputs !== 0) {
            return $this->inputs;
        } else {
            $Sql_Query = "UPDATE blog_posts SET `post_id` = :Post_ID, `post_title` = :Post_Title, `post_text` = :Post_Text, `post_date` = :Post_Date, `post_visible` = :Post_Visible, `post_tags` = :Post_Tags WHERE `post_id` = :Post_ID";
            $Parameter = array(":Post_ID" => $Post_ID, ":Post_Title" => $Post_Title, ":Post_Text" => $Post_Text, ":Post_Date" => $Post_Date, ":Post_Visible" => $Post_Visible, ":Post_Tags" => $Post_Tags);
            $return = $this->Connection->Execute_PDO_Command($Sql_Query, $Parameter);
            return $return;
        }
    }

    /*
     * 
     * Function to delete a specific Post from the EDIT-Mode
     */

    public function Delete_Post($post_id) {
        $ID = intval($post_id);
        $Sql_Query = "DELETE FROM blog_posts WHERE `post_id` = :Post_ID ";
        $Parameter = array(":Post_ID" => $ID);

        $return = $this->Connection->Execute_PDO_Command($Sql_Query, $Parameter);

        return $return;
    }

    /*
     * 
     * Function to set a new Visibility Status to a specific Post
     */

    public function Set_Visibility($post_id) {
        $function = filter_input(INPUT_GET, "func");
        switch ($function) {
            case "vis":
                $ID = intval($post_id);

                $Sql_Query = "UPDATE blog_posts SET `post_visible`='1' WHERE `post_id` = :Post_ID ";
                $Parameter = array(":Post_ID" => $ID);

                $return = $this->Connection->Execute_PDO_Command($Sql_Query, $Parameter);
                break;
            case "hid":
                $ID = intval($post_id);

                $Sql_Query = "UPDATE blog_posts SET `post_visible`='0' WHERE `post_id` = :Post_ID ";
                $Parameter = array(":Post_ID" => $ID);

                $return = $this->Connection->Execute_PDO_Command($Sql_Query, $Parameter);
                break;
        }
    }

    /*
     * 
     * Generates a Blog-ID out of the Post-ID (to be visible in a Post-Link)
     */

    public function List_Up_All_Valid_Posts($edit_return = null, $post_id = null) {
        $posts = $this->get_posts();
        foreach ($posts as $p) {
            $id = $this->generate_blog_id($p["post_id"]);
            $title = htmlentities($p["post_title"], ENT_COMPAT, "UTF-8");
            $date = new DateTime($p["post_date"]);
            $date = $date->format("d.m.Y, H:i");

            if ($id == $post_id) {
                if ($edit_return) {
                    if ($p["post_visible"] == 1) {
                        echo '<div id="post_' . $id . '" class="blog_post_container_success" >'
                        . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="Date: ' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=hid&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'><div class="delete_blog_post__center_x">X</div></div>'
                        . '</div>';
                    } else {
                        echo '<div id="post_' . $id . '" class="blog_post_container_success" >'
                        . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="Date: ' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=vis&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/not_visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'><div class="delete_blog_post__center_x">X</div></div>'
                        . '</div>';
                    }
                } else {
                    if ($p["post_visible"] == 1) {
                        echo '<div id="post_' . $id . '" class="blog_post_container" >'
                        . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="Date: ' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=hid&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'><div class="delete_blog_post__center_x">X</div></div>'
                        . '</div>';
                    } else {
                        echo '<div id="post_' . $id . '" class="blog_post_container" >'
                        . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="Date: ' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=vis&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/not_visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'><div class="delete_blog_post__center_x">X</div></div>'
                        . '</div>';
                    }
                }
            } else {
                if ($p["post_visible"] == 1) {
                    echo '<div id="post_' . $id . '" class="blog_post_container" >'
                    . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="Date: ' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=hid&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'><div class="delete_blog_post__center_x">X</div></div>'
                    . '</div>';
                } else {
                    echo '<div id="post_' . $id . '" class="blog_post_container" >'
                    . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="Date: ' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=vis&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/not_visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'><div class="delete_blog_post__center_x">X</div></div>'
                    . '</div>';
                }
            }
        }
    }

    /*
     * 
     * Generates a Blog-ID out of the Post-ID (to be visible in a Post-Link)
     */

    private function generate_blog_id($id) {
        $return = $id;
        while (strlen($return) <= 3) {
            $return = "0" . $return;
        }
        return $return;
    }

    /*
     * 
     * Returns all posts from DB
     */

    private function get_posts() {
        $Sql_Query = "SELECT * FROM blog_posts ORDER BY post_date DESC ";
        $posts = $this->Connection->Return_PDO_Array($Sql_Query);
        return $posts;
    }

    /*
     * 
     * Return Date in specific format ("Y-m-d, H:i:s")
     */

    private function date($Date_Calendary, $Date_Time) {
        $date_str = $Date_Calendary . ", " . $Date_Time;
        $date = new DateTime($date_str);
        return $date->format("Y-m-d, H:i:s");
    }

    /*
     * 
     * Function to check for SQL/HTML-Input
     */

    private function check_input($Input_Value, $Input_Name) {
        $Check_Input = new Check_Input();
        $Check_Input->Check($Input_Value);
        if ($Check_Input->status) {
            return $Input_Value;
        } else {
            $return = array();
            $return["message"] = $Check_Input->message;
            $return["value"] = $Input_Value;
            $this->inputs[$Input_Name] = $return;
        }
    }

}
