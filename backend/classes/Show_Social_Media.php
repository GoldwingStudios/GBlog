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
        foreach ($media as $m) {
            if ($m["sml_link"] != "") {
                $output = '' .
                        '<div class="social__media__badge">' .
                        '<img class="social__media__badge__icon" src="assets/images/' . $m["sml_type"] . '.svg">' .
                        '<div class="social__media__badge__content">' .
                        '<h1 class="social__media__badge__title">' . ucfirst($m["sml_type"]) . '</h1>' .
                        '<a href="http://' . $m["sml_link"] . '" class="social__media__badge__desc">' . $m["sml_link_text"] . '</a>' .
                        '</div>' .
                        '</div>';
                echo $output;
            }
        }
    }

    private function get_social_media_data() {
        $connection = new sql_connect();

        $sql_str = "SELECT * FROM blog_social_media_links ORDER BY sml_id ASC";
        $links = $connection->return_array($sql_str);
        return $links;
    }

}
