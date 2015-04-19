<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Write_Post {

    public function Write_Post_($title, $text, $tags) {
        $connection = new sql_connect();
        $connection = $connection->mysqli();
        $preview = $this->get_preview($text);
        $date = $this->get_date();

        $id = $connection->query("SELECT max(id) as id FROM blog_posts ");
        $id = $id->fetch_all();
        $id_ = $id[0][0] + 1;

        $sql_str = "INSERT INTO blog_posts (`id`, `post_title`, `post_preview`, `date`) VALUES (?, ?, ?, ?)";

        if ($stmt = $connection->prepare($sql_str)) {
            $stmt->bind_param("isss", $id_, $title, $preview, $date);
            $return = $stmt->execute(); //returns true if succeed and otherwise false
        }
//        print_r($id_ . $message . $sender . $date);
        $connection->close();

        if ($return) {
            $title_ = utf8_encode(utf8_decode($title));
            $text_ = utf8_encode(utf8_decode($text));
            $tags_ = $this->switch_from_special($tags);
            $write_to_xml_file = $this->write_to_file($id_, $title_, $date, $text_, $tags_);
            return $write_to_xml_file > 0;
        } else {
            return false;
        }
    }

    private function get_date() {
        $date = new DateTime();
        return $date->format("Y-m-d H:i:s");
    }

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

    private function switch_from_special($str) {
        $str_ = str_replace("ä", "&auml;", $str);
        $str_ = str_replace("ö", "&ouml;", $str_);
        $str_ = str_replace("ü", "&uuml;", $str_);
        $str_ = str_replace("ß", "&szlig;", $str_);
        return $str_;
    }

    private function write_to_file($id, $title, $date, $text, $tags) {
        $date = new DateTime($date);
        $date = $date->format("d.m.Y, H:i");
        $xml = new DOMDocument();
        $xml->formatOutput = true;

        $xml_post = $xml->createElement("post");

        $xml_title = $xml->createElement("title");
        $xml_tags = $xml->createElement("tags");
        $xml_date = $xml->createElement("date");
        $xml_text = $xml->createElement("text");
        $xml_visible = $xml->createElement("visible");
        $xml_comments = $xml->createElement("comments");


        $xml_title->nodeValue = $title;
        $xml_tags->nodeValue = $tags;
        $xml_date->nodeValue = $date;
        $xml_text->nodeValue = $text;
        $xml_visible->nodeValue = "1";
        $xml_comments->nodeValue = " ";


        $xml_post->appendChild($xml_title);
        $xml_post->appendChild($xml_tags);
        $xml_post->appendChild($xml_date);
        $xml_post->appendChild($xml_text);
        $xml_post->appendChild($xml_visible);
        $xml_post->appendChild($xml_comments);



        $xml->appendChild($xml_post);
        $x = $xml->save("../post_data/posts/post_$id.xml");
        return $x;
    }

}
