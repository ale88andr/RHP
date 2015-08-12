<?php

namespace Environment\Core;

use Environment\Config\Configuration;
use Environment\Core\Exceptions\CallActionException;
use Environment\Helpers\Hash;
use \Exception as Exception;
use Environment\Core\Exceptions\RequireFileException;

class App extends Foundation
{
    protected $controller, $controllerName, $action, $route, $params = [];

    /**
     * Application html layout name
     *
     * @var string
     */
    static private $layout;

    /**
     * Controller generated content
     *
     * @var string
     */
    public $content;

    protected static $defaultTitle;

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
     * @return void
     */
    private function applyController($url)
    {
        $this->getController($url);

        try{
            $this->createControllerInstance($this->controllersPath() . $this->controller . '.php');
        } catch (RequireFileException $e){
            ActionController::routingError($e);
        }

        $this->action = (empty($url[0])) ? Hash::get($this->route, 'action') : Hash::extract($url);
        $this->applyControllerAction($url);
    }

    /**
     * Require controller by request params.
     *
     * @param string $filePath controller file path
     * @throws RequireFileException
     * @return void
     */
    private function createControllerInstance($filePath)
    {
        if (file_exists($filePath)) {
            require_once $filePath;
            $this->controller = new $this->controller($this);
        } else {
            throw new RequireFileException('controller', $this->controller, $this->controllersPath());
        }
    }

    /**
     * Set's controller name
     *
     * @param array $url Request string (URI)
     * @return void
     */
    private function getController(&$url)
    {
        $controller = Hash::extract($url);
        $route = $this->routes->get($controller);

        if (Hash::keyExists($route, 'resource')) {
            $controller = $route['resource'];
        }

        if(is_null($controller)) {
            $route = $this->routes->get('root');
            $controller = Hash::get($route, 'resource');
        }

        $this->controller = $this->controllerName = $controller;
        $this->route = $route;
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
        try {
            $this->pathNames($this->route);
            if (Hash::keyExists($this->route, 'only') && !Hash::contains($this->route['only'], $this->action)) {
                throw new CallActionException(
                    $this->controllerName,
                    $this->action,
                    $this->route['only']
                );
            } elseif (method_exists($this->controller, $this->action)) {
                $this->params = $url;
                ob_start();
                call_user_func_array([$this->controller, $this->action], $this->params);
                $this->content = ob_get_clean();
            } else {
                throw new CallActionException(
                    get_class($this->controller),
                    $this->action
                );
            }
        } catch(CallActionException $e){
            ActionController::routingError($e);
        }
    }

    private function pathNames()
    {
        if(Hash::keyExists($this->route, 'alias')){
            $names = array_flip($this->route['alias']);
            if(Hash::keyExists($names, $this->action)){
                $this->action = $names[$this->action];
            }
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
        static::$layout = ($layout) ? $layout : 'application';
    }

    /**
     * Get application html layout.
     *
     * @return Srting
     */
    private function getLayout()
    {
        return static::$layout;
    }

    /**
     * Apply application html layout.
     *
     * @throws Exception
     * @return string
     */
    public function layout()
    {
        $dir = $this->viewsPath() . 'layouts' . DIRECTORY_SEPARATOR;
        $file = static::getLayout() . '.html.php';
        $layout = $dir . $file;
        try{
            if (file_exists($layout)) {
                return $layout;
            } else {
                throw new RequireFileException('layout', $file, $this->viewsPath() . 'layouts' . DIRECTORY_SEPARATOR);
            }
        } catch (RequireFileException $e){
            die($e);
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

    private function beforeLoad()
    {
        $this->setErrorReporting();
        $this->removeMagicQuotes();
        $this->setTimeZone();
        session_start();
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