<?php
namespace Repositories;

class TeamRepository extends Repository {
    public function getTeams() {
        return $this->query('SELECT * FROM team');
    }
}