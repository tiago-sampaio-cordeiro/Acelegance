<?php

namespace Tests\Unit\Core\Router;

use Core\Constants\Constants;
use Core\Http\Request;
use Core\Router\Route;
use Core\Router\Router;
use Tests\TestCase;

class RouteTest extends TestCase
{
    public function testShouldCreateRouteUsingConstructor(): void
    {
        $route = new Route(method: 'GET', uri: '/', controllerName: MockController::class, actionName: 'action');

        $this->assertEquals('GET', $route->getMethod());
        $this->assertEquals('/', $route->getURI());
        $this->assertEquals(MockController::class, $route->getControllerName());
        $this->assertEquals('action', $route->getActionName());
    }

    public function testShouldAddRouteToTheRouterMethodGet(): void
    {
        $routerReflection = new \ReflectionClass(Router::class);
        $instanceProperty = $routerReflection->getProperty('instance');
        $instanceProperty->setAccessible(true);
        // Store the original instance
        $originalInstance = $instanceProperty->getValue();

        $routerMock = $this->createMock(Router::class);
        $routerMock->expects($this->once())
            ->method('addRoute')
            ->with($this->callback(function ($route) {
                return $route instanceof Route
                    && $route->getMethod() === 'GET'
                    && $route->getUri() === '/test'
                    && $route->getControllerName() === 'TestController'
                    && $route->getActionName() === 'test';
            }));
        $instanceProperty->setValue(null, $routerMock);

        $route = Route::get('/test', ['TestController', 'test']);
        $this->assertInstanceOf(Route::class, $route);


        // Restore the original instance
        $instanceProperty->setValue(null, $originalInstance);
    }



    public function testShouldAddRouteToTheRouterMethodPost(): void
    {
        $routerReflection = new \ReflectionClass(Router::class);
        $instanceProperty = $routerReflection->getProperty('instance');
        $instanceProperty->setAccessible(true);
        // Store the original instance
        $originalInstance = $instanceProperty->getValue();

        $routerMock = $this->createMock(Router::class);
        $routerMock->expects($this->once())
            ->method('addRoute')
            ->with($this->callback(function ($route) {
                return $route instanceof Route
                    && $route->getMethod() === 'POST'
                    && $route->getUri() === '/test'
                    && $route->getControllerName() === 'TestController'
                    && $route->getActionName() === 'test';
            }));
        $instanceProperty->setValue(null, $routerMock);

        $route = Route::post('/test', ['TestController', 'test']);
        $this->assertInstanceOf(Route::class, $route);

        // Restore the original instance
        $instanceProperty->setValue(null, $originalInstance);
    }

    public function testShouldAddRouteToTheRouterMethodPut(): void
    {
        $routerReflection = new \ReflectionClass(Router::class);
        $instanceProperty = $routerReflection->getProperty('instance');
        $instanceProperty->setAccessible(true);
        // Store the original instance
        $originalInstance = $instanceProperty->getValue();

        $routerMock = $this->createMock(Router::class);
        $routerMock->expects($this->once())
            ->method('addRoute')
            ->with($this->callback(function ($route) {
                return $route instanceof Route
                    && $route->getMethod() === 'PUT'
                    && $route->getUri() === '/test'
                    && $route->getControllerName() === 'TestController'
                    && $route->getActionName() === 'test';
            }));
        $instanceProperty->setValue(null, $routerMock);

        $route = Route::put('/test', ['TestController', 'test']);
        $this->assertInstanceOf(Route::class, $route);

        // Restore the original instance
        $instanceProperty->setValue(null, $originalInstance);
    }

    public function testShouldAddRouteToTheRouterMethodDelete(): void
    {
        $routerReflection = new \ReflectionClass(Router::class);
        $instanceProperty = $routerReflection->getProperty('instance');
        $instanceProperty->setAccessible(true);
        // Store the original instance
        $originalInstance = $instanceProperty->getValue();

        $routerMock = $this->createMock(Router::class);
        $routerMock->expects($this->once())
            ->method('addRoute')
            ->with($this->callback(function ($route) {
                return $route instanceof Route
                    && $route->getMethod() === 'DELETE'
                    && $route->getUri() === '/test'
                    && $route->getControllerName() === 'TestController'
                    && $route->getActionName() === 'test';
            }));
        $instanceProperty->setValue(null, $routerMock);

        $route = Route::delete('/test', ['TestController', 'test']);
        $this->assertInstanceOf(Route::class, $route);

        // Restore the original instance
        $instanceProperty->setValue(null, $originalInstance);
    }

    public function testMatchShouldReturnTrueIfMethodAndUriMatch(): void
    {
        $route = new Route(method: 'GET', uri: '/', controllerName: 'MockController', actionName: 'index');

        $this->assertTrue($route->match($this->request('GET', '/')));
    }

    public function testMatchShouldReturnFalseIfMethodAndUriDoNotMatch(): void
    {
        $route = new Route(method: 'GET', uri: '/', controllerName: 'MockController', actionName: 'index');

        $this->assertFalse($route->match($this->request('POST', '/')));
        $this->assertFalse($route->match($this->request('GET', '/test')));
    }

    public function testNameShouldSetTheNameOfTheRoute(): void
    {
        $route = new Route(method: 'GET', uri: '/', controllerName: 'MockController', actionName: 'index');
        $route->name('root');

        $this->assertEquals('root', $route->getName());
    }

    public function testMatchShouldReturnTrueIfMethodAndUriWithParamsMatch(): void
    {
        $route = new Route(method: 'GET', uri: '/test/{id}', controllerName: 'MockController', actionName: 'show');
        $route->name('test.show');

        $this->assertTrue($route->match($this->request('GET', '/test/1')));
        $this->assertFalse($route->match($this->request('GET', '/test/1/edit')));
        $this->assertFalse($route->match($this->request('GET', '/test')));
    }


    public function testMatchShouldReturnTrueAndAddAaramsIfMethodAndUriWithParamsMatch(): void
    {
        $route = new Route(method: 'GET', uri: '/test/{id}', controllerName: 'MockController', actionName: 'show');

        $request = $this->request('GET', '/test/1');

        $this->assertTrue($route->match($request));
        $this->assertEquals(['id' => 1], $request->getParams());
    }

    public function testMatchShouldReturnTrueUsingQueryParams(): void
    {
        $route = new Route(method: 'GET', uri: '/test', controllerName: 'MockController', actionName: 'show');
        $request = $this->request('GET', '/test?user_id=1&id=2');

        $this->assertTrue($route->match($request));
    }

    private function request(string $method, string $uri): Request
    {
        require_once Constants::rootPath()->join('tests/Unit/Core/Http/header_mock.php');

        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;
        $_REQUEST = [];
        return new Request();
    }

    // public function test_add_middleware(): void
    // {
    //     $route = new Route(method: 'GET', uri: '/test', controllerName: 'MockController', actionName: 'show');
    //     $middleware = $this->createMock(Middleware::class);

    //     $route->addMiddleware($middleware);

    //     $reflection = new \ReflectionObject($route);
    //     $property = $reflection->getProperty('middlewares');
    //     $property->setAccessible(true);

    //     $middlewares = $property->getValue($route);

    //     $this->assertContains($middleware, $middlewares);
    // }
}
