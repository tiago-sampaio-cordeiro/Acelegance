<?php

namespace Core\Router;

use Core\Http\Request;

class Route
{
    private string $name = '';

    public function __construct(
        private string $method,
        private string $uri,
        private string $controllerName,
        private string $actionName
    ) {
    }

    public function name(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }


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

    public function match(Request $request): bool
    {
        return $this->isSameMethod($request) && $this->isSameUri($request);
    }

    private function isSameMethod(Request $request): bool
    {
        // return $this->method === $request->getMethod();
        return strtoupper($this->method) === strtoupper($request->getMethod());
    }

    private function isSameUri(Request $request): bool
    {

        $uri = strtok($request->getUri(), '?');

        $splittedRoute = explode('/', $this->getUri());
        $splittedUri = explode('/', $uri);

        if (sizeof($splittedRoute) !== sizeof($splittedUri)) {
            return false;
        }

        $params = [];

        foreach ($splittedRoute as $index => $routePart) {
            if (preg_match('/^{[a-z,_]+}$/', $routePart)) {
                $key = substr($routePart, 1, -1);
                $params[$key] = $splittedUri[$index];
            } elseif ($routePart !== $splittedUri[$index]) {
                return false;
            }
        }

        $request->addParams($params);
        return true;
    }

    /**
     * @param string $uri
     * @param mixed[] $actionName
     * @return Route
     */
    public static function get(string $uri, $actionName): Route
    {
        return Router::getInstance()->addRoute(new Route('GET', $uri, $actionName[0], $actionName[1]));
    }

    /**
     * @param string $uri
     * @param mixed[] $actionName
     * @return Route
     */
    public static function post(string $uri, mixed $actionName): Route
    {
        return Router::getInstance()->addRoute(new Route('POST', $uri, $actionName[0], $actionName[1]));
    }

    /**
     * @param string $uri
     * @param mixed[] $actionName
     * @return Route
     */
    public static function put(string $uri, mixed $actionName): Route
    {
        return Router::getInstance()->addRoute(new Route('PUT', $uri, $actionName[0], $actionName[1]));
    }

    /**
     * @param string $uri
     * @param mixed[] $actionName
     * @return Route
     */
    public static function delete(string $uri, mixed $actionName): Route
    {
        return Router::getInstance()->addRoute(new Route('DELETE', $uri, $actionName[0], $actionName[1]));
    }
}
