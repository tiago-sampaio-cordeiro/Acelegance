<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testCanSetName()
    {
        $product = new Product(name: 'Test Product');
        $product->setName('Test Product');
        $this->assertEquals('Test Product', $product->getName());
    }

    public function testShouldCreateNewProduct()
    {
        $product = new Product(name: 'Test Product');
        $this->assertTrue($product->save());
        $this->assertEquals(0, $product->getId());
        $this->assertCount(1, Product::all());
    }
}
