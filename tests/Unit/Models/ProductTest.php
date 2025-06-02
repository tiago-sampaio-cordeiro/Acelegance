<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testCanSetName(): void
    {
        $product = new Product(name: 'Test Product');
        $product->setName('Test Product');
        $this->assertEquals('Test Product', $product->getName());
    }

    public function testShouldCreateNewProduct(): void
    {
        $product = new Product(name: 'Test Product');
        $this->assertTrue($product->save());
        $this->assertGreaterThan(0, $product->getId());
        $this->assertCount(1, Product::all());
    }
}
