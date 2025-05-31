<?php

namespace Core\Router;

class Route
{
    public function __construct(
        private string $method,
        private string $uri,
        private $controllerName,
        private $actionName
    ) {}


    public function getMethod(): string
    {
        return $this->method;
    }
    public function getUri(): string
    {
        return $this->uri;
    }
    public function getControllerName(): string
    {
        return $this->controllerName;
    }
    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function match($method, $uri): bool
    {
        return $this->method === $method && $this->uri === $uri;
    }

    public static function get(string $uri, $actionName)
    {
        Router::getInstance()->addRoute(new Route('GET', $uri, $actionName[0], $actionName[1]));
    }
}
