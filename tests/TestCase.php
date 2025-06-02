<?php

namespace Tests;

use Core\Constants\Constants;
use Core\Database\Database;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    public function setUp(): void
    {
        Database::create();
        Database::migrate();
    }

    public function tearDown(): void
    {
        Database::drop();
    }




    protected function getOutPut(callable $callback): string
    {
        ob_start();
        $callback();
        return ob_get_clean();
    }
}
