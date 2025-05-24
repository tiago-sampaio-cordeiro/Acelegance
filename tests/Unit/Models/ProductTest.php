<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function test_can_set_name()
    {
        $product = new Product(name: 'Test Product');
        $product->setName('Test Product');
        $this->assertEquals('Test Product', $product->getName());
    }

    public function test_should_create_new_product()
    {
        $product = new Product(name: 'Test Product');
        $this->assertTrue($product->save());
        $this->assertEquals(0, $product->getId());
        $this->assertCount(1, Product::all());
    }
}
