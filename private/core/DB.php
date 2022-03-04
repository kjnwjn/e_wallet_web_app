<?php
class DB
{
    public $conn;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'test';

    function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        mysqli_select_db($this->conn, $this->dbname);
        mysqli_query($this->conn, "SET NAMES 'utf8'");
    }
}
