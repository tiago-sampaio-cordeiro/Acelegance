<?php

namespace Tests\Unit\Controllers;

use Core\Constants\Constants;
use Tests\TestCase;

abstract class ControllerTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        require Constants::rootPath()->join('config/routes.php');
    }

    public function get(string $action, string $controller): string
    {

        $controller = new $controller();

        ob_start();
        try {
            $controller->$action();
            $response = ob_get_clean();
            return $response;
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }
    }
}
