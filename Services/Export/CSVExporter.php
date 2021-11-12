<?php
namespace Services\Export;

use Services\Export\Export;

class CSVExporter implements Export {
    public function render($data): string
    {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv";');
        if (!$data->count()) {
            return '';
        }
        $csv = [];

        // extract headings
        // replace underscores with space & ucfirst each word for a decent headings
        $headings = collect($data->get(0))->keys();
        $headings = $headings->map(function($item, $key) {
            return collect(explode('_', $item))
                ->map(function($item, $key) {
                    return ucfirst($item);
                })
                ->join(' ');
        });
        $csv[] = $headings->join(',');

        // format data
        foreach ($data as $dataRow) {
            $csv[] = implode(',', array_values($dataRow));
        }
        return implode("\n", $csv);
    }
}