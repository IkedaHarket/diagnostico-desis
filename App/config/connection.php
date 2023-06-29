<?php 
class Database
{
    private static $instance; 
    private $connection; 

    private $db_host = 'localhost';
    private $db_name = 'desis_vote';
    private $db_user = 'root';
    private $db_password = '';

    private function __construct()
    {
        $this->connection = new PDO("mysql:host=$this->db_host;dbname=$this->db_name", $this->db_user, $this->db_password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->exec("SET NAMES utf8");
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

