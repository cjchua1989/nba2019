<?php
namespace Repositories;

class PlayerRepository extends Repository {
    private $search;

    public function parseSearch($args): PlayerRepository {
        $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
        $this->search = $args->filter(function($value, $key) use ($searchArgs) {
            return in_array($key, $searchArgs);
        });

        return $this;
    }

    public function getPlayers() {
        $where = [];
        if ($this->search->has('playerId')) $where[] = "roster.id = '" . $this->search['playerId'] . "'";
        if ($this->search->has('player')) $where[] = "roster.name = '" . $this->search['player'] . "'";
        if ($this->search->has('team')) $where[] = "roster.team_code = '" . $this->search['team']. "'";
        if ($this->search->has('position')) $where[] = "roster.position = '" . $this->search['position'] . "'";
        if ($this->search->has('country')) $where[] = "roster.nationality = '" . $this->search['country'] . "'";
        $where = implode(' AND ', $where);
        $sql = "
            SELECT roster.*
            FROM roster
            WHERE $where";

        return collect($this->query($sql))
            ->map(function($item, $key) {
                unset($item['id']);
                return $item;
            });
    }
}