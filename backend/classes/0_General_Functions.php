<?php

class General_Functions {
    /*
     * Generates a  specific post-ID from the title
     * The Blog-ID is visible in the URL
     */

    public function Generate_Blog_ID($id) {

        $id = str_replace("~", "_", $id);
        $id = str_replace("-", "_", $id);
        $id = str_replace(" ", "_", $id);
        $id = str_replace("ä", "ae", $id);
        $id = str_replace("ö", "oe", $id);
        $id = str_replace("ü", "ue", $id);
        $id = str_replace("Ä", "ae", $id);
        $id = str_replace("Ö", "oe", $id);
        $id = str_replace("Ü", "ue", $id);
        $id = str_replace("ß", "ss", $id);

        $id = str_replace(".", "", $id);
        $id = str_replace(":", "", $id);
        $id = str_replace(",", "", $id);
        $id = str_replace(";", "", $id);
        $id = str_replace("|", "", $id);
        $id = str_replace("<", "", $id);
        $id = str_replace(">", "", $id);
        $id = str_replace("@", "", $id);
        $id = str_replace("µ", "", $id);
        $id = str_replace("#", "", $id);
        $id = str_replace("+", "", $id);
        $id = str_replace("'", "", $id);
        $id = str_replace("#", "", $id);
        $id = str_replace("!", "", $id);
        $id = str_replace("?", "", $id);
        $id = str_replace("\\", "", $id);
        $id = str_replace("*", "", $id);
        $id = str_replace("{", "", $id);
        $id = str_replace("}", "", $id);
        $id = str_replace("(", "", $id);
        $id = str_replace(")", "", $id);
        $id = str_replace("[", "", $id);
        $id = str_replace("]", "", $id);
        $id = str_replace("=", "", $id);
        $id = str_replace("´", "", $id);
        $id = str_replace("`", "", $id);
        $id = str_replace('"', "", $id);
        $id = str_replace("§", "", $id);
        $id = str_replace("%", "", $id);
        $id = str_replace("&", "und", $id);
        $id = str_replace("/", "", $id);

        $id = htmlentities(strtolower($id));


        return $id;
    }

    public function Change_HTML_Title($text) {
        $text_decoded = html_entity_decode($text);
        $output_title = "<script>$(document).attr('title'," . "\"Post: $text_decoded --- \" + $(document).attr('title'));</script>";
        echo $output_title;
    }

}
