<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Comment_Loader {

    public function Load_Comments() {
        $Comments = $this->Get_Comments();
        if (count($Comments) > 0) {
            foreach ($Comments as $comment) {
                if ($comment["comment_valid"] != 1) {
                    $id = $comment["id"];
                    $name = $this->check((string) $comment["comment_name"]) ? null : htmlentities((string) $comment["comment_name"]);
                    $date = $this->check((string) $comment["comment_date"]) ? null : htmlspecialchars((string) $comment["comment_date"]);
                    $text = $this->check((string) $comment["comment_text"]) ? null : htmlentities((string) $comment["comment_text"]);
                    if ($name != null && $date != null && $text != null) {
                        echo '<div class="comment"><div class="comment_name">' . $name . '</div><div class="comment_date">' . $date . '</div><div class="comment_text">' . $text . '</div><div class="comment_confirm" onclick=\'window.location.href="index.php?sm=comma&id=' . $id . '&name=' . $name . '&date=' . $date . '&cmd=confirm"\'><div class="comment_edit_text">Confirm</div></div><div class="comment_delete" onclick=\'window.location.href="index.php?sm=comma&id=' . $id . '&cmd=delete"\'><div class="comment_edit_text">Delete</div></div></div>';
                    } else {
                        echo '<div class="comment"><div class="comment_name">' . $name . '</div><div class="comment_date">' . $date . '</div><div class="comment_text">Comment broken!</div><div class="comment_delete" onclick=\'window.location.href="index.php?sm=comma&id=' . $id . '&name=' . $name . '&date=' . $date . '&cmd=delete"\'><div class="comment_edit_text">Delete</div></div></div>';
                    }
                }
            }
        }
    }

    private function check($input) {
        if (!$html = $this->Check_Input_For_Html($input)) {
            if (!$sql = $this->Check_Input_For_Sql($input)) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    private function Check_Input_For_Html($string) {
        if ($string != strip_tags($string)) {
            return true;
        } else {
            return false;
        }
    }

    private function Check_Input_For_Sql($string) {
        $array = array("SELECT", "UPDATE", "DELETE");
        if (in_array($string, $array)) {
            return true;
        } else {
            return false;
        }
    }

    private function Get_Comments() {
        $connection = new sql_connect();
        $connection = $connection->mysqli();
        $id = intval($post);
        $sql_str = "SELECT * FROM blog_comments WHERE comment_valid != 1";

        if ($stmt = $connection->prepare($sql_str)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $return = $stmt->get_result();
            while ($row = $return->fetch_assoc()) {
                $comments[] = $row;
            }
        }
        $connection->close();
        return $comments;
    }

}
