<?php

namespace Environment\Routing;

class Route
{
    protected $uri;

    protected $controller;

    protected $action;

    protected $parameters;

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    public function __construct($uri)
    {
        print_r('Router was called with uri: '.$uri);
    }

}