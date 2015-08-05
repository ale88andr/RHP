<?php

namespace Environment\Core;

use Environment\Config\Configuration;
use Environment\Helpers\Hash;
use Environment\Interfaces\Application\Foundation as FoundationInterface;

class Foundation implements FoundationInterface
{

    const VERSION = '0.2.1 pre Alpha';

    private $basePath;

    private $appPath;

    private $corePath;

    private $configPath;

    private $controllersPath;

    private $viewsPath;

    private $modelsPath;

    public $routes;

    public $config;

    /**
     * @return mixed
     */
    public function modelsPath()
    {
        return $this->modelsPath;
    }

    /**
     * @return string
     */
    public function appPath()
    {
        return $this->appPath;
    }

    /**
     * @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * @return mixed
     */
    public function configPath()
    {
        return $this->configPath;
    }

    /**
     * @return string
     */
    public function corePath()
    {
        return $this->corePath;
    }

    /**
     * @return string
     */
    public function controllersPath()
    {
        return $this->controllersPath;
    }

    /**
     * @return string
     */
    public function viewsPath()
    {
        return $this->viewsPath;
    }

    public function __construct()
    {
        $this->basePath         = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . DIRECTORY_SEPARATOR;
        $this->appPath          = $this->basePath . 'app' . DIRECTORY_SEPARATOR;
        $this->corePath         = $this->basePath . 'src' . DIRECTORY_SEPARATOR . 'Environment' . DIRECTORY_SEPARATOR;
        $this->configPath       = $this->basePath . 'config' . DIRECTORY_SEPARATOR;
        $this->controllersPath  = $this->appPath . 'controllers' . DIRECTORY_SEPARATOR;
        $this->viewsPath        = $this->appPath . 'views' . DIRECTORY_SEPARATOR;
        $this->modelsPath       = $this->appPath . 'models' .DIRECTORY_SEPARATOR;
        $this->initializeAppEnvironment();
    }

    public function version()
    {
        return static::VERSION;
    }

    public function initializeAppEnvironment()
    {
        $this->config = new Configuration($this->configPath . 'env.php');
        $this->routes = new Configuration($this->configPath . 'routes.php');
    }

    protected function setErrorReporting()
    {
        error_reporting(E_ALL);
        if ($this->config->get('environment') == 'development') {
            ini_set('display_errors', 'On');
        }
        else {
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set(
                'error_log',
                $this->basePath() .
                DIRECTORY_SEPARATOR . 'tmp' .
                DIRECTORY_SEPARATOR . 'logs' .
                DIRECTORY_SEPARATOR . 'error.log'
            );
        }
    }

    protected function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
        return ($value);
    }

    protected function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = $this->stripSlashesDeep($_GET);
            $_POST = $this->stripSlashesDeep($_POST);
            $_COOKIE = $this->stripSlashesDeep($_COOKIE);
        }
    }

    protected function setTimeZone()
    {
        $timezone = $this->config->get('timezone');
        if(is_string($timezone)){
            date_default_timezone_set($timezone);
        }
    }

} 