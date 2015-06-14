<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Save_Comment_Request {

    public function write_comment_to_file($post_id) {
        $id = intval($post_id);
        $name = filter_input(INPUT_POST, "user_name");
        $mail = $this->check_mail(filter_input(INPUT_POST, "user_mail")) ? null : filter_input(INPUT_POST, "user_mail");
        $text = filter_input(INPUT_POST, "user_text");
        $date = $this->get_date();
        $path = "./post_data/posts/post_$id.xml";

        if ($mail != null) {
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

    private function get_date() {
        $date = new DateTime();
        return $date->format("Y-m-d H:i:s");
    }

    private function switch_from_special($str) {
        $str_ = str_replace("ä", "&auml;", $str);
        $str_ = str_replace("ö", "&ouml;", $str_);
        $str_ = str_replace("ü", "&uuml;", $str_);
        $str_ = str_replace("ß", "&szlig;", $str_);
        return $str_;
    }

    function check_mail($mail) {
        return preg_match("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$", $mail);
    }

}
