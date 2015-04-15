/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php

class Show_Hide_Post {

    function __construct() {
        $connection = new sql_connect();
        $this->connection = $connection->mysqli();
    }

    public function Set_Visibility($post_id, $function) {
        switch ($function) {
            case "vis":
                $id = intval($post_id);

                $sql_str = "UPDATE blog_posts SET `visible`=? WHERE `id`=" . $id;
                $visible = 1;
                if ($stmt = $this->connection->prepare($sql_str)) {
                    $stmt->bind_param("i", $visible);
                    $return = $stmt->execute(); //returns true if succeed and otherwise false
                }
                $this->connection->close();
                $this->connection = null;
                $stmt = null;

                if ($return) {
                    $post = $this->get_post($id);
                    $xml = new DOMDocument();
                    $xml->formatOutput = true;

                    $xml_post = $xml->createElement("post");

                    $xml_title = $xml->createElement("title");
                    $xml_tags = $xml->createElement("tags");
                    $xml_date = $xml->createElement("date");
                    $xml_text = $xml->createElement("text");
                    $xml_visible = $xml->createElement("visible");


                    $xml_title->nodeValue = $post->title;
                    $xml_tags->nodeValue = $post->tags;
                    $xml_date->nodeValue = $post->date;
                    $xml_text->nodeValue = $post->text;
                    $xml_visible->nodeValue = 1;

                    $xml_post->appendChild($xml_title);
                    $xml_post->appendChild($xml_tags);
                    $xml_post->appendChild($xml_date);
                    $xml_post->appendChild($xml_text);
                    $xml_post->appendChild($xml_visible);



                    $xml->appendChild($xml_post);
                    $x = $xml->save("../post_data/posts/post_$id.xml");
                    return $x;
                }
                break;
            case "hid":
                $id = intval($post_id);

                $sql_str = "UPDATE blog_posts SET `visible`=? WHERE `id`=" . $id;
                $visible = 0;
                if ($stmt = $this->connection->prepare($sql_str)) {
                    $stmt->bind_param("i", $visible);
                    $return = $stmt->execute(); //returns true if succeed and otherwise false
                }
                $this->connection->close();
                $this->connection = null;
                $stmt = null;

                if ($return) {
                    $post = $this->get_post($id);
                    $xml = new DOMDocument();
                    $xml->formatOutput = true;

                    $xml_post = $xml->createElement("post");

                    $xml_title = $xml->createElement("title");
                    $xml_tags = $xml->createElement("tags");
                    $xml_date = $xml->createElement("date");
                    $xml_text = $xml->createElement("text");
                    $xml_visible = $xml->createElement("visible");


                    $xml_title->nodeValue = $post->title;
                    $xml_tags->nodeValue = $post->tags;
                    $xml_date->nodeValue = $post->date;
                    $xml_text->nodeValue = $post->text;
                    $xml_visible->nodeValue = 0;

                    $xml_post->appendChild($xml_title);
                    $xml_post->appendChild($xml_tags);
                    $xml_post->appendChild($xml_date);
                    $xml_post->appendChild($xml_text);
                    $xml_post->appendChild($xml_visible);



                    $xml->appendChild($xml_post);
                    $x = $xml->save("../post_data/posts/post_$id.xml");
                    return $x;
                }
                break;
        }
    }

    private function get_post($id) {
        $id = intval($id);
        $load_string = "../post_data/posts/post_$id.xml";
        $post = simplexml_load_file($load_string);
        return $post;
    }

}
