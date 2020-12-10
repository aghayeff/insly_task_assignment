<?php
namespace App\Lib;

class ModuleLoader
{
    public static function load($absolutePathToModule)
    {
        $exports = require($absolutePathToModule);
        return (isset($exports['default'])) ? $exports['default'] : $exports;
    }
}
