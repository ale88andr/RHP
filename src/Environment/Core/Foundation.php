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
    }

} 