<?php

namespace Environment\Core;

use Environment\Config\Configuration;
use Environment\Core\Exceptions\CallActionException;
use Environment\Helpers\Hash;
use \Exception as Exception;
use Environment\Core\Exceptions\RequireFileException;

class App extends Foundation
{
    protected $controller, $action, $params = [];

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
            $this->controller = $this->routes->get('root.resource');
        }
        $controller_path = $this->controllersPath() . $this->controller . '.php';

        try{
            if (file_exists($controller_path)) {
                require_once $controller_path;

                $this->controller = new $this->controller($this);
                $this->action = (empty($url[0])) ? $this->routes->get('root.action') : Hash::shift($url);
                $this->applyControllerAction($url);
            } else {
                throw new RequireFileException('controller', $this->controller, $this->controllersPath());
            }
        } catch (RequireFileException $e){
            die($e);
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
        try{
            if (method_exists($this->controller, $this->action)) {
                $this->params = $url;
                ob_start();
                call_user_func_array([$this->controller, $this->action], $this->params);
                $this->content = ob_get_clean();
            } else {
                throw new CallActionException(get_class($this->controller), $this->action);

            }
        } catch(CallActionException $e){
            die($e);
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