<?php
namespace App\Lib;

use \mysqli AS Connection;

class DBConnection
{
    private $connection;

    public function getConnection()
    {
        return $this->connection;
    }

    public function connect($params)
    {
        return $this->connection = new Connection('p:'.$params['host'], $params['user'], $params['pass'], $params['name']);
    }

    public function disconnect() {
        if($this->connection) {
            mysqli_close($this->connection);
            $this->connection = null;
        }
    }
}
