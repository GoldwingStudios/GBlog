<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Social_Media_Links {

    public function __construct() {
        $this->Connection = new DB_Connect();
        $this->Get_Links();
    }

    public function Get_Links() {
        $post_types = $_POST["sml_type"];
        $post_links = $_POST["sml_link"];
        $counter = 0;
        if (count($post_types) > 0) {
            foreach ($post_types as $SML_key => $SML_type) {
                $this->links[$SML_type]["link"] = $post_links[$counter];
                $counter++;
            }
        }
        if (isset($_POST["submitted"])) {
            if (count($post_types) > 0) {
                $this->delete_links($post_types);
            }
        }
    }

    public function Set_SML() {
        foreach ($this->links as $key => $value) {
            $type = $key;
            $link = $value["link"];
            if ($type != "" && $link != "") {
                $link = $this->link_setup($link);

                if ($this->is_link_active($key)) {
                    $SQL_Str = "UPDATE blog_social_media_links SET `sml_link`=:SML_Link WHERE `sml_type`=:SML_Type";
                    $Paramters = array(":SML_Type" => $type, ":SML_Link" => $link);
                    $return = $this->Connection->Execute_PDO_Command($SQL_Str, $Paramters);
                } else {
                    $SQL_Str = "INSERT INTO blog_social_media_links (`sml_type`, `sml_link`) VALUES (:SML_Type, :SML_Link)";
                    $Paramters = array(":SML_Type" => $type, ":SML_Link" => $link);
                    $return = $this->Connection->Execute_PDO_Command($SQL_Str, $Paramters);
                }
            }
        }
        return $return;
    }

    public function Get_SML() {
        $Sql_Query = "SELECT * FROM blog_social_media_links ORDER BY sml_id ASC";
        $links = $this->Connection->Return_PDO_Array($Sql_Query);
        $counter = 0;
        foreach ($links as $link) {
            $files = glob("../assets/images/social_media/" . $link["sml_type"] . ".{jpg,jpeg,png,gif,svg}", GLOB_BRACE);
            if (count($files) == 0) {
                $links[$counter]["image_message"] = "No Image for this Link available! Please upload one soon ;)";
            }

            $counter++;
        }
        return $links;
    }

    private function is_link_active($link_type) {
        $sql_str = "SELECT sml_link as link FROM blog_social_media_links WHERE sml_type = '$link_type'";

        $return = count($this->Connection->Return_PDO_Array($sql_str)) == 1;
        return $return;
    }

    private function delete_links($post) {
        $links = $this->Get_SML();
        if (count($links) > 0) {
            foreach ($links as $link) {
                $type = $link["sml_type"];
                if (!in_array($type, $post)) {
                    $SQL_Str = "DELETE FROM blog_social_media_links WHERE sml_type = :SML_Type ";
                    $Paramters = array(":SML_Type" => $type);
                    $return = $this->Connection->Execute_PDO_Command($SQL_Str, $Paramters);
                }
            }
        }
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
