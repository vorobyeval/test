<?php

class DB
{
    static private $instance;
    public $db;
    private function __construct(){}

    static public function instance()
    {
        if(empty(self::$instance)){
            self::$instance = new self();
        }
        return static::$instance;
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function connect($host, $user, $pass, $dbname)
    {
        $this->db = new mysqli($host, $user, $pass, $dbname);
        if($this->db){
            return $this->db;
        }
    }
}