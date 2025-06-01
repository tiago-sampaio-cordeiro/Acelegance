<?php

namespace Tests\Unit\Controllers;

use App\Models\Product;

class ProductControllerTest extends ControllerTestCase
{
    public function testListAllProducts(): void
    {
        $products[] = new Product(name: 'Product 1');
        $products[] = new Product(name: 'Product 2');

        foreach ($products as $product) {
            $product->save();
        }

        $response = $this->get(action: 'index', controller: 'App\Controllers\ProductsController');

        foreach ($products as $product) {
            $this->assertMatchesRegularExpression("/{$product->getName()}/", $response);
        }
    }
}
