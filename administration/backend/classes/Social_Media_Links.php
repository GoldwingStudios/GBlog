<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Social_Media_Links {

    public function __construct($links, $dates) {
        $this->links = $links;
        $this->dates = $dates;
    }

    public function Set_SML() {
        $path = "./blog_config/social_media_links.xml";

        $xstr = file_get_contents($path); // XML-String
        $sXML = new SimpleXMLElement($xstr);
        foreach ($this->links as $link) {
            if ($link != "") {

                switch ($type = $this->get_type($link)) {
                    case "youtube":
                        if (strpos($xstr, "link_youtube") !== false) {
                            unset($sXML->link_youtube);
                        }
                        $username = $this->get_sm_username($type, $link);
                        $newchild = $sXML->addChild("link_youtube");
                        $type = $newchild->addChild("type", "youtube");
                        $username = $newchild->addChild("username", $username);
                        $link = $newchild->addChild("link", $link);
                        break;
                    case "twitter":
                        if (strpos($xstr, "link_twitter") !== false) {
                            unset($sXML->link_twitter);
                        }

                        $username = $this->get_sm_username($type, $link);
                        $newchild = $sXML->addChild("link_twitter");
                        $type = $newchild->addChild("type", "twitter");
                        $username = $newchild->addChild("username", $username);
                        $link = $newchild->addChild("link", $link);
                        break;
                    case "twitch":
                        if (strpos($xstr, "link_twitch") !== false) {
                            unset($sXML->link_twitch);
                        }

                        $date = $this->dates[0] . ", " . $this->dates[1];
                        $newchild = $sXML->addChild("link_twitch");
                        $type = $newchild->addChild("type", "twitch");
                        $link = $newchild->addChild("link", $link);
                        $dates = $newchild->addchild("date_time", $date);
                        break;
                }
            }
        }
        $x = file_put_contents($path, $sXML->asXML());
        return $x > 0;
    }

    private function get_type($link) {
        $link = $this->link_setup($link);
        if ($x = strpos($link, ".de")) {
            $part_2 = explode(".de", $link);
        } else if ($x = strpos($link, ".com")) {
            $part_2 = explode(".com", $link);
        } else if ($x = strpos($link, ".tv")) {
            $part_2 = explode(".tv", $link);
        }
        return $part_2[0];
    }

    private function get_sm_username($type, $link) {
        switch ($type) {
            case "youtube":
                $link_split = explode("user/", $link);
                $username = $link_split[1];
                break;
            case "twitter":
                $link_split = explode("com/", $link);
                $username = $link_split[1];
                break;
        }
        return (string) $username;
    }

    private function link_setup($link) {
        $str_ = str_replace("http://", "", $link);
        $str_ = str_replace("https://", "", $str_);
        $str_ = str_replace("www.", "", $str_);

        return $str_;
    }

}
