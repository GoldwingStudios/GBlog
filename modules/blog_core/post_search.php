/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php

class Post_Search {

    function search_for_posts($search_tag) {
        if (!$this->hashtml($search_tag)) {
            $posts_with_tag = array();
            $path = "../../post_data/posts/*.xml";
            $posts = glob($path);
            $search_tags = explode(" ", $search_tag);
            $i = 0;
            foreach ($posts as $p) {
                $post = simplexml_load_file($p);
                foreach ($search_tags as $tag) {
                    $x = strpos(strtolower($post->text), strtolower($tag));
                    $x++;
                    if ($x >= 1) {
                        $result = array();
                        $filename = explode("_", $p);
                        $id = explode(".", $filename[2]);
                        $id = $id[0];

                        $sql = new sql_connect();
                        $sql_str = "SELECT * FROM blog_posts WHERE visible='1' AND id=? ORDER BY date DESC ";
                        $connection = $sql->mysqli();
                        $return = 0;

                        if ($stmt = $connection->prepare($sql_str)) {
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $stmt->bind_result($id_, $post_title, $post_preview, $date, $visible);
                            $x = 0;
                            while ($stmt->fetch()) {
                                $result[$x]["id"] = $id_;
                                $result[$x]["post_title"] = $post_title;
                                $result[$x]["post_preview"] = $post_preview;
                                $result[$x]["date"] = $date;
                                $result[$x]["visible"] = $visible;
                            }
                        }

                        $posts_with_tag[$i]["xml"] = $post;
                        $posts_with_tag[$i]["sql"] = $result;
                        $connection->close();
                    } else if ($x != FALSE) {
                        $result = array();
                        $filename = explode("_", $p);
                        $id = explode(".", $filename[2]);
                        $id = $id[0];

                        $sql = new sql_connect();
                        $sql_str = "SELECT * FROM blog_posts WHERE visible='1' AND id=? ORDER BY date DESC ";
                        $connection = $sql->mysqli();
                        $return = 0;

                        if ($stmt = $connection->prepare($sql_str)) {
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $stmt->bind_result($id_, $post_title, $post_preview, $date, $visible);
                            $x = 0;
                            while ($stmt->fetch()) {
                                $result[$x]["id"] = $id_;
                                $result[$x]["post_title"] = $post_title;
                                $result[$x]["post_preview"] = $post_preview;
                                $result[$x]["date"] = $date;
                                $result[$x]["visible"] = $visible;
                            }
                        }

                        $posts_with_tag[$i]["xml"] = $post;
                        $posts_with_tag[$i]["sql"] = $result;
                        $connection->close();
                    }
                }
                $i++;
            }
            return $posts_with_tag;
        }
    }

    private function hashtml($string) {
        if ($string != strip_tags($string))
            return true;
        else
            return false;
    }

}
