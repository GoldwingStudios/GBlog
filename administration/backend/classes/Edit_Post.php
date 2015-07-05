<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Edit_Post {

    function __construct() {
        $connection = new sql_connect();
        $this->connection = $connection->mysqli();

        $this->post_id = $this->check_input(intval(filter_input(INPUT_GET, "id")), "id");
        $this->post_title = $this->check_input(filter_input(INPUT_POST, "post_title"), "post_title");
        $this->post_date = $this->date($this->check_input(filter_input(INPUT_POST, "post_date_calendar"), "post_date_calendar"), $this->check_input(filter_input(INPUT_POST, "post_date_time"), "post_date_time"));
        $this->post_text = $this->check_input(filter_input(INPUT_POST, "post_text"), "post_text");
        $this->post_tags = $this->check_input(filter_input(INPUT_POST, "post_tags"), "post_tags");
        $this->post_visible = $this->check_input(filter_input(INPUT_POST, "post_visible"), "post_visible");
    }

    public function Edit() {
        $count = count($this->inputs);
        if ($count !== 0) {
            return $this->inputs;
        } else {
            $sql_str = "UPDATE blog_posts SET `post_id`=?, `post_title`=?, `post_text`=?, `post_date`=?, `post_visible`=?, `post_tags`=? WHERE `post_id`=" . $this->post_id;
            if ($stmt = $this->connection->prepare($sql_str)) {
                $stmt->bind_param("isssis", $this->post_id, $this->post_title, $this->post_text, $this->post_date, $this->post_visible, $this->post_tags);
                $return = $stmt->execute(); //returns true if succeed and otherwise false
            }
//        print_r($id_ . $message . $sender . $date);
            $this->connection->close();
            $this->connection = null;
            $stmt = null;
            return $return;
        }
    }

    private function date($date_cal, $date_time) {
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
