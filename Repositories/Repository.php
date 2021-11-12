<?php
namespace Repositories;

use Services\Database;

abstract class Repository {
    protected $connection;

    public function __construct() {
        $this->connection = Database::getDatabase();
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }
}