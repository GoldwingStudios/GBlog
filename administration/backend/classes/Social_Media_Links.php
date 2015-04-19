<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Social_Media_Links {

    public function Set_SML($youtube_link, $twitter_link, $twitch_link) {
        $path = "./blog_config/social_media_links.xml";

        $xstr = file_get_contents($path);
        $sXML = new SimpleXMLElement($xstr);
        $newchild = $sXML->comments->addChild("comment");
        $newchild->addChild("comment_name", $name);
        $newchild->addChild("comment_mail", $mail);
        $newchild->addChild("comment_date", $date);
        $newchild->addChild("comment_text", $text);
        $newchild->addChild("valid", "0");
        $x = file_put_contents($path, $sXML->asXML());
        return $x > 0;
    }

}
