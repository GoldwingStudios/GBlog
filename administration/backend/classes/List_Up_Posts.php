<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class List_Up_Posts {

    public function List_Up_All_Posts($edit_return = null, $post_id = null) {
        $sql = new sql_connect();
        $sql_str = "SELECT * FROM blog_posts ORDER BY post_date DESC ";
        $posts = $sql->return_array($sql_str);
        foreach ($posts as $p) {
            $id = $this->generate_blog_id($p["post_id"]);

            $title = htmlentities($p["post_title"], ENT_COMPAT, "UTF-8");
            $date = new DateTime($p["post_date"]);
            $date = $date->format("d.m.Y, H:i");
            if ($id == $post_id) {
                if ($edit_return) {
                    if ($p["post_visible"] == 1) {
                        echo '<div id="post_' . $id . '" class="blog_post_container_success" >'
                        . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=hid&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'>X</div>'
                        . '</div>';
                    } else {
                        echo '<div id="post_' . $id . '" class="blog_post_container_success" >'
                        . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=vis&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/not_visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'>X</div>'
                        . '</div>';
                    }
                } else {
                    if ($p["post_visible"] == 1) {
                        echo '<div id="post_' . $id . '" class="blog_post_container" >'
                        . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=hid&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'>X</div>'
                        . '</div>';
                    } else {
                        echo '<div id="post_' . $id . '" class="blog_post_container" >'
                        . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=vis&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/not_visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'>X</div>'
                        . '</div>';
                    }
                }
            } else {
                if ($p["post_visible"] == 1) {
                    echo '<div id="post_' . $id . '" class="blog_post_container" >'
                    . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=hid&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'>X</div>'
                    . '</div>';
                } else {
                    echo '<div id="post_' . $id . '" class="blog_post_container" >'
                    . '<div class="blog_post" onclick=\'window.location.href="index.php?sm=edit&id=' . $id . '"\' title="' . $date . '"><span class="post_title_t">' . $title . '</span></div><div class="show_hide_blog_post" title="Show/Hide this post!" onclick=\'window.location.href="index.php?sm=edit&m=soh&func=vis&id=' . $id . '"\'><img alt="visible" src="./assets/images/edit_post/not_visible.png"/></div><div class="delete_blog_post" title="Delete this post!" onclick=\'window.location.href="index.php?sm=edit&m=del&id=' . $id . '"\'>X</div>'
                    . '</div>';
                }
            }
        }
    }

    private function generate_blog_id($id) {
        $return = $id;
        while (strlen($return) <= 3) {
            $return = "0" . $return;
        }
        return $return;
    }

}
