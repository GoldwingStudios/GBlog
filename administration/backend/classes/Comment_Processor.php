<?php

class Comment_Processor {

    public function Process_Comment($id, $cmd) {
        switch ($cmd) {
            case "confirm":
                $this->confirm_Comment($id);
                break;
            case "delete":
                $this->delete_Comment($id);
                break;
        }
    }

    private function confirm_Comment($id) {
        $id_ = intval($id);
        $connection = new sql_connect();
        $connection = $connection->mysqli();

        $sql_string = "UPDATE blog_comments SET `comment_valid`=1 WHERE id=? ";

        if ($stmt = $connection->prepare($sql_string)) {
            $stmt->bind_param("i", $id_);
            $return = $stmt->execute();
        }
    }

    private function delete_Comment($id) {
        $id_ = intval($id);
        $connection = new sql_connect();
        $connection = $connection->mysqli();

        $sql_string = "UPDATE blog_comments SET `comment_valid`='0' WHERE id=? ";

        if ($stmt = $connection->prepare($sql_string)) {
            $stmt->bind_param("i", $id_);
            $return = $stmt->execute();
        }
    }

}
