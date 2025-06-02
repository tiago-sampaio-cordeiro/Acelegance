<?php

namespace Tests\Unit\Core\Router;

use Core\Constants\Constants;
use Core\Exceptions\HTTPException;
use Core\Router\Route;
use Core\Router\Router;
use Tests\TestCase;

class RouterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        require_once Constants::rootPath()->join('tests/Unit/Core/Http/header_mock.php');
    }

    public function tearDown(): void
    {
        $routerReflection = new \ReflectionClass(Router::class);
        $instanceProperty = $routerReflection->getProperty('instance');
        $instanceProperty->setValue(null, null);
    }

    public function testSingletonShouldReturnTheSameObject(): void
    {
        $rOne = Router::getInstance();
        $rTwo = Router::getInstance();

        $this->assertSame($rOne, $rTwo);
    }

    public function testShouldNotBeAbleToCloneRouter(): void
    {
        $rOne = Router::getInstance();

        $this->expectException(\Error::class);
        $rTwo = clone $rOne;
    }

    public function testShouldNotBeAbleToInstantiateRouter(): void
    {
        $this->expectException(\Error::class);
        /** @phpstan-ignore-next-line */
        $r = new Router();
    }

    public function testShouldBePossibleToAddRouteToRouter(): void
    {
        $router = Router::getInstance();
        $router->addRoute(new Route('GET', '/test', MockController::class, 'action'));

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test';

        $output = $this->getOutPut(function () use ($router) {
            $this->assertInstanceOf(MockController::class, $router->dispatch());
        });

        $this->assertEquals('Action Called', $output);
    }

    public function testShouldNotDispatchIfRouteDoesNotMatch(): void
    {
        $router = Router::getInstance();
        $router->addRoute(new Route('GET', '/test', MockController::class, 'action'));

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/not-found';

            $this->expectException(HTTPException::class);
            $router->dispatch();
    }

    public function testShouldReturnARouteAfterAdd(): void
    {
        $router = Router::getInstance();
        $route = $router->addRoute(new Route('GET', '/test', MockController::class, 'action'));

        $this->assertInstanceOf(Route::class, $route);
    }

    public function testShouldGetRoutePathByName(): void
    {
        $router = Router::getInstance();
        $router->addRoute(new Route('GET', '/test', MockController::class, 'action'))->name('test');
        $router->addRoute(new Route('GET', '/test-1', MockController::class, 'action'))->name('test.one');

        $this->assertEquals('/test', $router->getRoutePathByName('test'));
        $this->assertEquals('/test-1', $router->getRoutePathByName('test.one'));
    }

    public function testShouldGetRoutePathByNameWithParams(): void
    {
        $router = Router::getInstance();
        $router->addRoute(new Route('GET', '/test/{id}', MockController::class, 'action'))->name('test');
        $router->addRoute(
            new Route('GET', '/test/{user_id}/test-1/{id}', MockController::class, 'action')
        )->name('test.one');

        $this->assertEquals('/test/1', $router->getRoutePathByName('test', ['id' => 1]));
        $this->assertEquals('/test/2/test-1/1', $router->getRoutePathByName('test.one', ['id' => 1, 'user_id' => 2]));
    }

    public function testShouldGetRoutePathByNameWithParamsWithDifferentOrder(): void
    {
        $router = Router::getInstance();
        $router->addRoute(
            new Route('GET', '/test/{user_id}/test-1/{id}', MockController::class, 'action')
        )->name('test.one');

        $this->assertEquals('/test/2/test-1/1', $router->getRoutePathByName('test.one', ['id' => 1, 'user_id' => 2,]));
    }

    public function testShouldGetRoutePathByNameWithParamsAndQueryParams(): void
    {
        $router = Router::getInstance();
        $router->addRoute(new Route('GET', '/test/{id}', MockController::class, 'action'))->name('test');

        $this->assertEquals('/test/1?search=MVC', $router->getRoutePathByName('test', ['id' => 1, 'search' => 'MVC']));
    }

    public function testShouldReturnAnExceptionIfTheNameDoesNotExist(): void
    {
        $router = Router::getInstance();
        $router->addRoute(new Route('GET', '/test', MockController::class, 'action'))->name('test');

        $this->expectException(\Exception::class);
        $router->getRoutePathByName('not-found');
    }

    // public function test_get_route_size(): void
    // {
    //     $router = Router::getInstance();
    //     $route = $this->createMock(Route::class);

    //     $router->addRoute($route);
    //     $router->addRoute($route);

    //     $this->assertEquals(2, $router->getRouteSize());
    // }

    // public function test_get_route(): void
    // {
    //     $router = Router::getInstance();
    //     $route1 = $this->createMock(Route::class);
    //     $route2 = $this->createMock(Route::class);

    //     $router->addRoute($route1);
    //     $router->addRoute($route2);

    //     $this->assertSame($route1, $router->getRoute(0));
    //     $this->assertSame($route2, $router->getRoute(1));
    // }
}
