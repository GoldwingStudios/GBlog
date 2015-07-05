<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class Sql_Connect {

    public function connect_to_database() {
        $connect = mysqli_connect("", "", "", "");
        return $connect;
    }

    private function Disconnect_From_Database($connection) {
        mysqli_close($connection);
    }

    public function mysqli() {
        $connect = new mysqli("", "", "", "");
        return $connect;
    }

    public function return_array($query) {
        $return = array();
        $connection = $this->connect_to_database();
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $return[] = $row;
        }
        $this->Disconnect_From_Database($connection);
        return $return;
    }

    public function return_row($query) {
        $ergebnis = Array();
        $connection = $this->connect_to_database();
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $ergebnis[] = $row;
        }
        $this->Disconnect_From_Database($connection);
        return $ergebnis[0];
    }

    public function execute($sql_string) {
        $connection = $this->connect_to_database();
        do {
            $result = mysqli_query($connection, $sql_string);
        } while (!$result);
        $this->Disconnect_From_Database($connection);
        return $result;
    }

}

?>