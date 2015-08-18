<?php

class Rss_Creator {

    function show_rss() {
        header("Content-type: text/xml");
        $sql = new sql_connect();
        echo '<?xml version="1.0" encoding="UTF-8" ?>';
        echo '<rss version="2.0">';
        echo "<channel>";
        echo "<title>GoldwingStudios Blog</title>
                <link>http://blog.goldwingstudios.de</link>
                <description>Infos zu Neuerungen und Updates zu unseren Produkten!</description>
                <language>de-de</language>
                <pubDate></pubDate>
                <lastBuildDate>" . date() . "</lastBuildDate>
                <docs>http://blog.goldwingstudios/?rss</docs>
                <generator>GoldwingStudios Blog</generator>
                <managingEditor>ocd@goldwingstudios.de</managingEditor>
                <webMaster>ocd@goldwingstudios.de</webMaster>";

        $sql_str = "SELECT * FROM blog_posts WHERE post_visible='1' ORDER BY post_date DESC ";
        $posts = $sql->return_array($sql_str);
        foreach ($posts as $p) {
            $id = $this->generate_blog_id($p["post_id"]);
            $date = new DateTime($p["post_date"]);
            $title = htmlentities($p["post_title"], ENT_COMPAT, "UTF-8");
            $text = $this->get_preview(str_replace("_", " ", $p["post_text"]));

            $date_hour = $date->format("G");
            $date_min = $date->format("i");

            $date_day = $date->format("D");
            $date_day_nr = $date->format("d");

            $month_name = $date->format("M");

            $year_nr = $date->format("Y");

            $rss_date = "$date_day, $date_day_nr $month_name $year_nr $date_hour:$date_min:00 +0000";

            echo "<item>";
            echo "<title>" . $p["post_title"] . "</title>";
            echo "<link>http://blog.goldwingstudios.de/?post=" . $id . "</link>";
            echo "<description>" . $text . " [...]</description>";
            echo "<pubDate>$rss_date</pubDate>";
            echo "<guid>http://blog.goldwingstudios.de</guid>";
            echo "</item>";
        }
        echo "</channel>";
        echo "</rss>";
    }

    private function generate_blog_id($id) {
        $return = $id;
        while (strlen($return) <= 3) {
            $return = "0" . $return;
        }
        return $return;
    }

    private function get_preview($text) {
        $steps = 125;
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
