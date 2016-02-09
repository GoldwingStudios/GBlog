<?php

class Comment_Processor {

    public function __construct() {
        $this->Connection = new DB_Connect();
        $this->Check = new Check_Input();
    }

    public function Process_Comment($id, $cmd) {
        switch ($cmd) {
            case "confirm":
                $Post_ID = intval($id);
                $Sql_Query = "UPDATE blog_comments SET `comment_valid`='1' WHERE `id` = :Post_ID ";
                $Parameter = array(":Post_ID" => $Post_ID);
                $return = $this->Connection->Execute_PDO_Command($Sql_Query, $Parameter);
                break;
            case "delete":
                $Post_ID = intval($id);
                $Sql_Query = "UPDATE blog_comments SET `comment_valid`='-1' WHERE `id` = :Post_ID ";
                $Parameter = array(":Post_ID" => $Post_ID);
                $return = $this->Connection->Execute_PDO_Command($Sql_Query, $Parameter);
                break;
        }
    }

    public function Load_Comments() {
        $Comments = $this->Get_Comments();
        if (count($Comments) > 0) {
            foreach ($Comments as $comment) {
                if ($comment["comment_valid"] != 1) {
                    $id = $comment["id"];
                    $name = $this->Check->Check((string) $comment["comment_name"]) ? null : htmlentities((string) $comment["comment_name"]);
                    $date = $this->Check->Check((string) $comment["comment_date"]) ? null : htmlspecialchars((string) $comment["comment_date"]);
                    $text = $this->Check->Check((string) $comment["comment_text"]) ? null : htmlentities((string) $comment["comment_text"]);
                    if ($name != null && $date != null && $text != null) {
                        echo '<div class="comment"><div class="comment_name">' . $name . '</div><div class="comment_date">' . $date . '</div><div class="comment_text">' . $text . '</div><div class="comment_confirm" onclick=\'window.location.href="index.php?sm=comma&id=' . $id . '&name=' . $name . '&date=' . $date . '&cmd=confirm"\'><div class="comment_edit_text">Confirm</div></div><div class="comment_delete" onclick=\'window.location.href="index.php?sm=comma&id=' . $id . '&cmd=delete"\'><div class="comment_edit_text">Delete</div></div></div>';
                    } else {
                        echo '<div class="comment"><div class="comment_name">' . $name . '</div><div class="comment_date">' . $date . '</div><div class="comment_text">Comment broken!</div><div class="comment_delete" onclick=\'window.location.href="index.php?sm=comma&id=' . $id . '&name=' . $name . '&date=' . $date . '&cmd=delete"\'><div class="comment_edit_text">Delete</div></div></div>';
                    }
                }
            }
        } else {
            echo '<div class="label label-warning" style="font-size: 17px;">No Comments!</div>';
        }
    }

    private function Get_Comments() {
        $Sql_Query = "SELECT * FROM blog_comments WHERE comment_valid = '0'";

        $Comments = $this->Connection->Return_PDO_Array($Sql_Query);
        return $Comments;
    }

}
