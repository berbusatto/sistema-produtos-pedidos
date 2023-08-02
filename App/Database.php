<?php
    require_once 'Config.php';
class Database
{
    private $conn;

    /**
     * @return mysqli
     */
    public function getConn()
    {
        return $this->conn;
    }

    public function __construct()
    {
        $db = new Config();

        $this->conn = new mysqli($db->getDbHost(), $db->getDbUsername() , $db->getDbPassword() , $db->getDbName());

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}