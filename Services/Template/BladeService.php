<?php
namespace Services\Template;

use Jenssegers\Blade\Blade;

class BladeService {
    private static $instance = null;

    static function getService(): Blade {
        if(static::$instance == null){
            self::$instance = new Blade('../../views', '../../cache');
        }
        return self::$instance;
    }
}