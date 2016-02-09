<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Write_Post {

    public function __construct() {
        
    }

    public function Write_New_Post($Post_Title, $Post_Text, $Post_Tags) {
        $Connection = new DB_Connect();
        $Post_Preview = $Post_Text;
        $Post_Date = $this->get_date();
        $Image_Path = $this->get_post_image($Post_Date);

        $Sql_Query = "INSERT INTO blog_posts (`post_title`, `post_text`, `post_date`, `post_tags`, `post_image_path`) VALUES (:post_title, :post_text, :post_date, :post_tags, :post_image_path)";
        $Parameter = array(":post_title" => $Post_Title, ":post_text" => $Post_Preview, ":post_date" => $Post_Date, ":post_tags" => $Post_Tags, ":post_image_path" => $Image_Path);
        $return = $Connection->Execute_PDO_Command($Sql_Query, $Parameter);
        return $return;
    }

    private function get_date() {
        $date = new DateTime();
        return $date->format("Y-m-d H:i:s");
    }

    private function get_post_image($Date) {
        $Image = $_FILES["post_image"];
        $Save_Date = date("d_m_Y_H_i_s", strtotime($Date));
        $Target_File_Return = "./assets/images/post_images/" . $Save_Date . "_" . strtolower($Image["name"]);
        $Target_File = "../assets/images/post_images/" . $Save_Date . "_" . strtolower($Image["name"]);
        $Moved = move_uploaded_file($_FILES["post_image"]["tmp_name"], $Target_File);
        if ($Moved) {
            return $Target_File_Return;
        } else {
            return "";
        }
    }

}
