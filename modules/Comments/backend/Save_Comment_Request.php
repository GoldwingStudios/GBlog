<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Save_Comment_Request {

    public function __construct() {
        $this->Connection = new DB_Connect();
    }

    public function Write_Comment($post_id) {
        $post_id = intval($post_id);
        $comment_name = filter_input(INPUT_POST, "user_name");
        $comment_mail = $this->check_mail(filter_input(INPUT_POST, "user_mail")) ? null : filter_input(INPUT_POST, "user_mail");
        $comment_text = filter_input(INPUT_POST, "user_text");
        $comment_date = $this->get_date();
        $comment_valid = 0;

        if ($comment_mail != null) {
            $SQL_String = "INSERT INTO blog_comments (`post_id`, `comment_name`, `comment_mail`, `comment_text`, `comment_date`, `comment_valid`) VALUES (:Post_ID, :Comment_Name, :Comment_Mail, :Comment_Text, :Comment_Date, :Comment_Valid)";
            $Parameters = array(":Post_ID" => $post_id, ":Comment_Name" => $comment_name, ":Comment_Mail" => $comment_mail, ":Comment_Text" => $comment_text, ":Comment_Date" => $comment_date, ":Comment_Valid" => $comment_valid);
            $return = $this->Connection->Execute_PDO_Command($SQL_String, $Parameters);
            return $return;
        }
    }

    private function get_date() {
        $date = new DateTime();
        return $date->format("Y-m-d H:i:s");
    }

    function check_mail($mail) {
        return preg_match("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^", $mail);
    }

}
