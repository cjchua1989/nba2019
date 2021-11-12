<?php
namespace Classes;

use Repositories\PlayerRepository;
use Repositories\PlayerStatRepository;
use Services\Export\ExportFactory;

class Controller {
    private $playerRepository;
    private $playerStatRepository;

    public function __construct($args) {
        $this->args = $args;
        $this->playerRepository = new PlayerRepository();
        $this->playerStatRepository = new PlayerStatRepository();
    }

    public function export($type, $format): string {
        $exporter = ExportFactory::getService($format);
        $data = [];
        switch ($type) {
            case 'playerstats':
                $data = $this->playerStatRepository->parseSearch($this->args)->getPlayerStats();
                break;
            case 'players':
                $data = $this->playerRepository->parseSearch($this->args)->getPlayers();
                break;
        }
        if (!$data) {
            exit("Error: No data found!");
        }
        return $exporter->render($data);
    }
}