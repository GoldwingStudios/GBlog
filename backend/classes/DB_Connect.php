<?php

/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
class DB_Connect {

    public function __construct() {
        
    }

    /*
     * 
     * Function is used to create a new Connection to the Database
     */

    private function connect_to_database() {
        $connect = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PASSWORD);
        return $connect;
    }

    /*
     * 
     * Function is used to Retreive a Result Array from the DB
     */

    public function Return_PDO_Array($Query, $Parameter = null) {
        $return = NULL;
        $Connection = $this->connect_to_database();

        if ($PDO_Stmt = $Connection->prepare($Query)) {
            $PDO_Stmt->execute($Parameter);
            $return = $PDO_Stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $Connection = null;
        return $return;
    }

    /*
     * 
     * Function is used to Retreive a Result Row from the DB
     */

    public function Return_PDO_Row($Query, $Parameter = null) {
        $return = NULL;
        $Connection = $this->connect_to_database();

        if ($PDO_Stmt = $Connection->prepare($Query)) {
            $PDO_Stmt->execute($Parameter);
            $return = $PDO_Stmt->fetch(PDO::FETCH_ASSOC);
        }
        $Connection = null;
        return $return;
    }

    /*
     * 
     * Function is used to Execute a Command SQL in the DB
     */

    public function Execute_PDO_Command($Query, $Parameter = null) {
        $return = NULL;
        $Connection = $this->connect_to_database();

        if ($PDO_Stmt = $Connection->prepare($Query)) {
            $return = $PDO_Stmt->execute($Parameter);
        }
        $Connection = null;
        return $return;
    }

}

?>