<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class sql_connect {

    public function connect_to_database() {
        $connect = mysqli_connect("localhost", "db_connect", "Zx6%3_!y", "blog");
        return $connect;
    }

    public function mysqli() {
        $connect = new mysqli("localhost", "db_connect", "Zx6%3_!y", "blog");
        return $connect;
    }

    public function disconnect_from_database($connection) {
        mysqli_close($connection);
    }

    public function return_array($query) {
        $return = array();
        $connection = $this->connect_to_database();
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)) {
            $return[] = $row;
        }
        $this->disconnect_from_database($connection);
        return $return;
    }

    public function return_row($query) {
        $ergebnis = Array();
        $connection = $this->connect_to_database();
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)) {
            array_push($ergebnis, $row);
        }
        $this->disconnect_from_database($connection);
        return $ergebnis[0];
    }

    public function execute($sql_string) {
        $connection = $this->connect_to_database();
        do {
            $result = mysqli_query($connection, $sql_string);
        } while (!$result);
        $this->disconnect_from_database($connection);
        return $result;
    }

}
?>