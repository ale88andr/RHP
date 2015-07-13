<?php

namespace Environment\Core;

class Controller
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function model($model_name = '')
    {
        $model_name = empty($model_name) ? get_class($this) : trim(strtolower($model_name));
        $file = $this->app->appPath() . 'models' .
                DIRECTORY_SEPARATOR . $model_name . '.php';
        if (file_exists($file)) {
            require_once $file;

            return new $model_name;
        } else {
            echo
                'Model "' . $model_name . '" not found. Searched in: "' .
                $this->app->appPath() . 'models' . DIRECTORY_SEPARATOR . '"';
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
                DIRECTORY_SEPARATOR . $path['partial_dir'] .
                DIRECTORY_SEPARATOR . $path['partial'];
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo
                'Partial "' . $path['partial'] . '" not found. Searched in: "' .
                $this->app->appPath() . 'views' . DIRECTORY_SEPARATOR .
                $path['partial_dir'] . DIRECTORY_SEPARATOR . '"';
        }
    }

    private function getPartialPath($partial)
    {
        $path = [];
        $partial = ltrim($partial, '/') . '.html.php';
        if (!strpos($partial, '/')) {
            $path['partial_dir'] = strtolower(get_class($this));
            $path['partial'] = $partial;
        } else {
            $tmp = explode('/', $partial);
            $path['partial'] = array_pop($tmp);
            $path['partial_dir'] = join($tmp);
        }

        return $path;
    }
}