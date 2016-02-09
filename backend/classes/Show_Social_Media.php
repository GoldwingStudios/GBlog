<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Show_Social_Media {

    public function Show_Social_Media_Links() {
        $media = $this->get_social_media_data();
        if(count($media) > 0)
        {
            echo '<h2>Social Media</h2><div class="blog__social__media">';
        }
        foreach ($media as $m) {
            if ($m["sml_link"] != "") {
                $output = '' .
                '<a href="http://' . $m["sml_link"] . '" class="social__media__badge__desc"><div class="social__media__badge">' .
                '<img class="social__media__badge__icon" src="assets/images/social_media/' . $m["sml_type"] . '.svg">' .
                '<div class="social__media__badge__content">' .
                '<div class="helper"></div>' .
                '<h1 class="social__media__badge__title">' . ucfirst($m["sml_type"]) . '</h1>' .
                '</div>' .
                '</div>' .
                '</a>' ;
                echo $output;
            }
        }
        if(count($media) > 0)
        {
            echo "</div>";
        }
    }

    private function get_social_media_data() {
        $Connection = new DB_Connect();

        $sql_str = "SELECT * FROM blog_social_media_links ORDER BY sml_id ASC";
        $links = $Connection->Return_PDO_Array($sql_str);
        return $links;
    }

}
