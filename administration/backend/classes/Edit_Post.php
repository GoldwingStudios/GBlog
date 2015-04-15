/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php

class Edit_Post {

    function __construct() {
        $connection = new sql_connect();
        $this->connection = $connection->mysqli();

        $this->post_id = $this->check_input(intval(filter_input(INPUT_GET, "id")), "id");
        $this->post_title = $this->check_input(filter_input(INPUT_POST, "post_title"), "post_title");
        $this->post_date_calendar = $this->check_input(filter_input(INPUT_POST, "post_date_calendar"), "post_date_calendar");
        $this->post_date_time = $this->check_input(filter_input(INPUT_POST, "post_date_time"), "post_date_time");
        $this->post_text = $this->check_input(filter_input(INPUT_POST, "post_text"), "post_text");
        $this->post_tags = $this->check_input(filter_input(INPUT_POST, "post_tags"), "post_tags");
        $this->post_visible = $this->check_input(filter_input(INPUT_POST, "post_visible"), "post_visible");
    }

    public function Edit() {
        $count = count($this->inputs);
        if ($count !== 0) {
            return $this->inputs;
        } else {
            $sql_str = "UPDATE blog_posts SET `id`=?, `post_title`=?, `post_preview`=?, `date`=?, `visible`=? WHERE `id`=" . $this->post_id;
            $id = $this->post_id;
            $title = $this->post_title;
            $text = $this->get_preview($this->post_text);
            $date = $this->date();
            $visible = $this->post_visible;
            if ($stmt = $this->connection->prepare($sql_str)) {
                $stmt->bind_param("isssi", $id, $title, $text, $date, $visible);
                $return = $stmt->execute(); //returns true if succeed and otherwise false
            }
//        print_r($id_ . $message . $sender . $date);
            $this->connection->close();
            $this->connection = null;
            $stmt = null;

            if ($return) {
                $id_ = $this->post_id;
                $title_ = utf8_encode(utf8_decode($this->post_title));
                $text_ = utf8_encode(utf8_decode($this->post_text));
                $tags_ = $this->switch_from_special($this->post_tags);
                $write_to_xml_file = $this->write_to_file($id_, $title_, $date, $text_, $tags_, $visible);
                return $write_to_xml_file > 0;
            } else {
                return false;
            }
        }
    }

    private function write_to_file($id, $title, $date, $text, $tags, $visible) {

        $xml = new DOMDocument();
        $xml->formatOutput = true;

        $xml_post = $xml->createElement("post");

        $xml_title = $xml->createElement("title");
        $xml_tags = $xml->createElement("tags");
        $xml_date = $xml->createElement("date");
        $xml_text = $xml->createElement("text");
        $xml_visible = $xml->createElement("visible");


        $xml_title->nodeValue = $title;
        $xml_tags->nodeValue = $tags;
        $xml_date->nodeValue = $date;
        $xml_text->nodeValue = $text;
        $xml_visible->nodeValue = $visible;


        $xml_post->appendChild($xml_title);
        $xml_post->appendChild($xml_tags);
        $xml_post->appendChild($xml_date);
        $xml_post->appendChild($xml_text);
        $xml_post->appendChild($xml_visible);



        $xml->appendChild($xml_post);
        $x = $xml->save("../post_data/posts/post_$id.xml");
        return $x;
    }

    private function switch_from_special($str) {
        $str_ = str_replace("ä", "&auml;", $str);
        $str_ = str_replace("ö", "&ouml;", $str_);
        $str_ = str_replace("ü", "&uuml;", $str_);
        $str_ = str_replace("ß", "&szlig;", $str_);
        return $str_;
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

    private function date() {
        $date_cal = $this->post_date_calendar;
        $date_time = $this->post_date_time;
        $date_str = $date_cal . ", " . $date_time;
        $date = new DateTime($date_str);
        return $date->format("Y-m-d, H:i:s");
    }

    private function check_input($input, $name) {
        $Check_Input = new Check_Input();
        $Check_Input->Check($input);
        if ($Check_Input->status) {
            return $input;
        } else {
            $return = array();
            $return["message"] = $Check_Input->message;
            $return["value"] = $input;
            $this->inputs[$name] = $return;
        }
    }

}
