<?php
namespace Services\Export;

use Services\Export\Export;

class JSONExporter implements Export {
    public function render($data): string
    {
        header('Content-type: application/json');
        return json_encode($data->all());
    }
}