<?php

class analytics {

    function write_use_data() {
        $sql = new sql_connect();
        $string_ = "SELECT max(count) FROM analytics";
        $x = $sql->return_array($string_);
        $y = intval($x[0][0]) + 1;

        $string = "INSERT INTO analytics "
                . "SET count='$y'";
        $return = $sql->execute($string);
        return $return;
    }

}
