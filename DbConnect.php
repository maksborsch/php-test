<?php

class DbConnect {
    private $server = 'localhost:3307';
    private $dbname = 'test';
    private $user = 'root';
    private $pass = "";
    public function connect() {
        try {
            $conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }

}
// $server = 'localhost:3307';
// $dbname = 'test';
// $user = 'root';
// $pass = "";
// $conn = mysqli_connect($server, $user, $pass, $dbname);
// function sql_connect()
// {
//     global $conn;
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }
//     return $conn;
// }
