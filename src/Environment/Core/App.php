<?php

namespace Environment\Core;

use Environment\Config\Configuration;
use Environment\Helpers\Hash;
use \Exception as Exception;

class App extends Foundation
{
    protected $controller, $action, $params = [];

    /**
     * Application html layout name
     *
     * @var string
     */
    static private $_layout;

    /**
     * Controller generated content
     *
     * @var string
     */
    public $content;

    private static $defaultTitle;

    function __construct()
    {
        parent::__construct();
        try {
            $this->beforeLoad();
            $this->applyController($this->parseURL());
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
        if (empty(static::$_layout)) {
            static::setLayout();
        }
    }

    /**
     * Controller handler by request params.
     *
     * @param array $url Request string (URI)
     * @throws Exception
     * @return void
     */
    private function applyController($url)
    {
        $this->controller = Hash::shift($url);
        if(is_null($this->controller)) {
            $this->controller = 'home';
        }
        $controller_path = $this->controllersPath() . $this->controller . '.php';
        if (file_exists($controller_path)) {
            require_once $controller_path;

            $this->controller = new $this->controller($this);
            $this->action = (empty($url[0])) ? 'index' : Hash::shift($url);
            $this->applyControllerAction($url);
        }
        else {
            throw new Exception("Controller '{$this->controller}' not found. Searched in: '{$this->controllersPath()}'
                <br />Search path: {$controller_path}");
        }
    }

    /**
     * Action handler by request params.
     *
     * @param array $url Part of request URI
     * @throws Exception
     * @return void
     */
    private function applyControllerAction($url)
    {
        if (method_exists($this->controller, $this->action)) {
            $this->params = $url;
            ob_start();
            call_user_func_array([$this->controller, $this->action], $this->params);
            $this->content = ob_get_clean();
        }
        else {
            throw new Exception("Controller '" . get_class($this->controller) . "' does't have action '{$this->action}'");
        }
    }

    /**
     * Set application html layout.
     *
     * @param bool|string $layout HTML layout name
     * @return void
     */
    public static function setLayout($layout = false)
    {
        static::$_layout = ($layout) ? $layout : 'application';
    }

    /**
     * Get application html layout.
     *
     * @return Srting
     */
    private function getLayout()
    {
        return static::$_layout;
    }

    /**
     * Apply application html layout.
     *
     * @throws Exception
     * @return string
     */
    public function layout()
    {
        $layout_dir = $this->viewsPath() . 'layouts' . DIRECTORY_SEPARATOR;
        $layout_file = static::getLayout() . '.html.php';
        $layout = $layout_dir . $layout_file;
        if (file_exists($layout)) {
            return $layout;
        }
        else {
            throw new Exception("Layout {$layout_file} not found. Searched in {$layout_dir}");
        }
    }

    /**
     * Parse request URI
     *
     * @return array
     */
    function parseURL()
    {
        return $url = explode('/', filter_var(trim($_SERVER['REQUEST_URI'], '/') , FILTER_SANITIZE_URL));
    }

    private function setErrorReporting()
    {
        error_reporting(E_ALL);
        if ($this->config->get('environment') == 'development') {
            ini_set('display_errors', 'On');
        }
        else {
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', $this->basePath() . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'error.log');
        }
    }

    private function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
        return ($value);
    }

    private function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = $this->stripSlashesDeep($_GET);
            $_POST = $this->stripSlashesDeep($_POST);
            $_COOKIE = $this->stripSlashesDeep($_COOKIE);
        }
    }

    private function setTimeZone()
    {
        $timezone = $this->config->get('timezone');
        if(is_string($timezone)){
            date_default_timezone_set($timezone);
        }
    }

    private function beforeLoad()
    {
        $this->setErrorReporting();
        $this->removeMagicQuotes();
        $this->setTimeZone();
        static::$defaultTitle = $this->config->get('title');
    }

    public function title()
    {
        return static::$defaultTitle;
    }

    public static function setTitle($title = null, $separator = ' - ')
    {
        if(!is_null($title)){
            static::$defaultTitle .= $separator . $title;
        }
    }
}