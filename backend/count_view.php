/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php

class views {

    function get_details($server) {
        $sql = new sql_connect();
        $date = date("Y-m-d H:i:s");
        $ip_remote = $server['REMOTE_ADDR'];
        $ip_proxy = $server['HTTP_X_FORWARDED_FOR'];
        $sql_string = "INSERT INTO views "
                . "SET ipadresse_remote='$ip_remote', datetime='$date', ipoadresse_proxy='$ip_proxy'";
        $sql->execute($sql_string);
    }

}
