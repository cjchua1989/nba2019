<?php
namespace Repositories;

class PlayerStatRepository extends Repository {
    private $search;

    public function parseSearch($args): PlayerStatRepository {
        $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
        $this->search = $args->filter(function($value, $key) use ($searchArgs) {
            return in_array($key, $searchArgs);
        });

        return $this;
    }

    public function getPlayerStats() {
        $where = [];
        if ($this->search->has('playerId')) $where[] = "roster.id = '" . $this->search['playerId'] . "'";
        if ($this->search->has('player')) $where[] = "roster.name = '" . $this->search['player'] . "'";
        if ($this->search->has('team')) $where[] = "roster.team_code = '" . $this->search['team']. "'";
        if ($this->search->has('position')) $where[] = "roster.pos = '" . $this->search['position'] . "'";
        if ($this->search->has('country')) $where[] = "roster.nationality = '" . $this->search['country'] . "'";
        $where = implode(' AND ', $where);

        $sql = "
            SELECT roster.name, player_totals.*
            FROM player_totals
                INNER JOIN roster ON (roster.id = player_totals.player_id)
            WHERE $where";
        $data = $this->query($sql) ?: [];

        // calculate totals
        foreach ($data as &$row) {
            unset($row['player_id']);
            $row['total_points'] = ($row['3pt'] * 3) + ($row['2pt'] * 2) + $row['free_throws'];
            $row['field_goals_pct'] = $row['field_goals_attempted'] ? (round($row['field_goals'] / $row['field_goals_attempted'], 2) * 100) . '%' : 0;
            $row['3pt_pct'] = $row['3pt_attempted'] ? (round($row['3pt'] / $row['3pt_attempted'], 2) * 100) . '%' : 0;
            $row['2pt_pct'] = $row['2pt_attempted'] ? (round($row['2pt'] / $row['2pt_attempted'], 2) * 100) . '%' : 0;
            $row['free_throws_pct'] = $row['free_throws_attempted'] ? (round($row['free_throws'] / $row['free_throws_attempted'], 2) * 100) . '%' : 0;
            $row['total_rebounds'] = $row['offensive_rebounds'] + $row['defensive_rebounds'];
        }
        return collect($data);
    }
}