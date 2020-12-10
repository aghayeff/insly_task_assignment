<?php
namespace App\Lib;

class Config
{
    /**
     * Allowed modes
     */
    const MODES = ['development', 'production'];

    private $params = [];

    /**
     * @throws \Error
     */
    public function __construct()
    {
        //$mode = getenv('MODE');
        $mode = 'production';

        if(trim($mode) === '') {
            throw new \Exception('MODE not defined');
        }

        if(!in_array($mode, self::MODES)) {
            throw new \Exception('Unsupported value: '.$mode.' for environment variable MODE');
        }

        $configFile = __DIR__.'/../config/'.$mode.'.php';
        $this->params = require_once $configFile;
    }

    /**
     * @param      $key
     * @param null $fallback
     *
     * @return bool|null|mixed
     */
    public function get($key, $fallback = null)
    {
        return isset($this->params[$key]) ? $this->params[$key] : $fallback;
    }
}
