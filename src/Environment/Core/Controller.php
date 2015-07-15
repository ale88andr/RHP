<?php

namespace Environment\Core;

use \Environment\Core\Exceptions\RequireFileException;
use Environment\Helpers\Hash;

class Controller
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function model($model_name = null)
    {
        $model = is_null($model_name) ? get_class($this) : trim(strtolower($model_name));
        $file = $this->app->appPath() . 'models' .
                DIRECTORY_SEPARATOR . $model . '.php';
        try{
            if (file_exists($file)) {
                require_once $file;

                return new $model;
            } else {
                throw new RequireFileException('model', $model, $this->app->modelsPath());
            }
        } catch (RequireFileException $e){
            die($e);
        }
    }

    public function render($partial, $data = [], $handle_data = true)
    {
        if ($handle_data === true) {
            foreach ($data as $varName => $value) {
                $ {
                    $varName
                } = $value;
            }

            unset($data);
        }

        $path = $this->getPartialPath($partial);
        $file = $this->app->appPath() . 'views' .
                DIRECTORY_SEPARATOR . $path['dir'] .
                DIRECTORY_SEPARATOR . $path['file'];
        try{
            if (file_exists($file)) {
                require_once $file;
            } else {
                throw new RequireFileException('view', Hash::get($path, 'file'), $this->app->viewsPath() . Hash::get($path, 'dir'));
            }
        } catch (RequireFileException $e){
            die($e);
        }
    }

    private function getPartialPath($partial)
    {
        $path = [];
        $partial = ltrim($partial, '/') . '.html.php';
        if (!strpos($partial, '/')) {
            $path['dir'] = strtolower(get_class($this));
            $path['file'] = $partial;
        } else {
            $tmp = explode('/', $partial);
            $path['file'] = array_pop($tmp);
            $path['dir'] = join($tmp);
        }

        return $path;
    }
}