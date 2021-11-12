<?php
namespace Services\Export;

class ExportFactory {
    static function getService($format): Export {
        switch($format) {
            case 'xml':
                return new XMLExporter();
            case 'csv':
                return new CSVExporter();
            case 'json':
                return new JSONExporter();
            default:
                return new HtmlExporter();
        }
    }
}