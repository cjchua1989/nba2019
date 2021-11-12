<?php
namespace Services\Export;

use Services\Template\BladeService;

class HtmlExporter implements Export {
    public function render($data): string
    {
        $blade = BladeService::getService();
        $headings = collect($data->get(0))->keys();
        $headings = $headings->map(function($item, $key) {
            return collect(explode('_', $item))
                ->map(function($item, $key) {
                    return ucfirst($item);
                })
                ->join(' ');
        });

        return $blade->render('export_html', [
            "headings" => $headings,
            "data" => $data,
        ]);
    }
}