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
        echo '<br><div class="social_media_title"><h3>Social Media</h3></div>';
        $media = $this->get_social_media_data();
        foreach ($media as $m) {
            if ($m->link != "") {
                if ($m->type == "twitch") {
                    echo '<a href="' . $m->link . '" target="_blank"><div class="social_link_container"><div class="social_media_img_centered"><div class="social_media_img_centered_inner"><img class="social_media_link" src="assets/images/social_media/' . $m->type . '_logo.png" ></div></div><span class="social_media_text">N&auml;chster Stream<br>' . $m->date_time . '</span></div></a>';
                } else {
                    echo '<a href="' . $m->link . '" target="_blank"><div class="social_link_container"><div class="social_media_img_centered"><div class="social_media_img_centered_inner"><img class="social_media_link" src="assets/images/social_media/' . $m->type . '_logo.png" ></div></div><div class="social_media_username_container"><span class="social_media_username">' . $m->username . '</span></div></div></a>';
                }
            }
        }
    }

    private function get_social_media_data() {
        $media = simplexml_load_file("administration/blog_config/social_media_links.xml");
        return $media;
    }

}
