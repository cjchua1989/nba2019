<?php
namespace Services;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $this->connection = new mysqli(
            env('DB_HOST', 'localhost'),
            env('DB_USERNAME', 'root'),
            env('DB_PASSWORD', 'password'),
            env('DB_NAME', 'nba2019')
        );
    }

    static function getDatabase(): Database {
        if(static::$instance == null){
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        if (!is_object($result)) {
            return $result;
        }
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}