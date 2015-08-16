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
        foreach ($_POST as $SML_key => $SML_link) {
            $contains_type = strpos($SML_key, "_type");
            $contains_link = strpos($SML_key, "_link");
            if (($contains_type === 0 || $contains_type !== FALSE) || ($contains_link === 0 || $contains_link != FALSE)) {
                $type = str_replace("_type", "", $SML_key);
                if ($contains_type === 0 || $contains_type !== FALSE) {
                    if (!isset($this->links[$type])) {
                        $this->links[$type]["type"] = $type;
                    }
                } else if ((int) $contains_link == 0 || $contains_link != FALSE) {
                    $type = str_replace("_link", "", $SML_key);
                    if (!isset($this->links[$type])) {
                        return;
                    } else {
                        if ($SML_link != "") {
                            $this->links[$type]["link"] = $SML_link;
                        }
                    }
                }
            }
        }
        if (isset($_POST["submitted"])) {
            $this->delete_links($_POST);
        }
    }

    public function Set_SML() {
        foreach ($this->links as $key => $value) {
            $type = $value["type"];
            $link = $value["link"];
            if ($type != "" && $link != "") {
                $link_text = $this->link_setup($link);

                if ($this->is_link_active($key)) {
                    $sql_str = "UPDATE blog_social_media_links SET `sml_link`=?, `sml_link_text`=? WHERE `sml_type`=?";

                    if ($stmt = $connection->prepare($sql_str)) {
                        $stmt->bind_param("sss", $link, $link_text, $key);
                        $return = $stmt->execute(); //returns true if succeed and otherwise false
                    }
                } else {
                    $sql_str = "INSERT INTO blog_social_media_links (`sml_type`, `sml_link`, `sml_link_text`) VALUES (?, ?, ?)";

                    if ($stmt = $connection->prepare($sql_str)) {
                        $stmt->bind_param("sss", $key, $link_text, $link);
                        $return = $stmt->execute(); //returns true if succeed and otherwise false
                    }
                }
                $connection->close();
                $connection = null;
                break;
            }
        }
    }

    public function Get_SML() {
        $Sql_Query = "SELECT * FROM blog_social_media_links ORDER BY sml_id ASC";
        $links = $this->Connection->Return_PDO_Array($Sql_Query);
        return $links;
    }

    private function is_link_active($link_type) {
        $connection = new sql_connect();
        $connection = $connection->mysqli();
        $sql_str = "SELECT sml_link as link FROM blog_social_media_links WHERE sml_type = '$link_type'";

        if ($stmt = $connection->prepare($sql_str)) {
            $stmt->execute(); //returns true if succeed and otherwise false
            $stmt->bind_result($link);
            $stmt->fetch();
            $return = !empty($link);
        }
        $connection->close();
        return $return;
    }

    private function delete_links($post) {
        $links = $this->Get_SML();
        foreach ($links as $link) {
            $type = $link["sml_type"] . "_type";
            if (!isset($post["$type"])) {
                $connection = new sql_connect();
                $connection = $connection->mysqli();

                $sql_type = $link["sml_type"];
                $SML_delete_sql = "DELETE FROM blog_social_media_links WHERE sml_type = ? ";

                if ($stmt = $connection->prepare($SML_delete_sql)) {
                    $stmt->bind_param("s", $sql_type);
                    $return = $stmt->execute(); //returns true if succeed and otherwise false
                }
                $connection->close();
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
