<?php

namespace Tests\Unit\Controllers;

use App\Controllers\ProductsController;
use App\Models\Product;
use Tests\TestCase;

class ProductControllerTest extends \Tests\TestCase
{
    public function test_list_all_products()
    {
        $products[] = new Product(name: 'Product 1');
        $products[] = new Product(name: 'Product 2');

        foreach ($products as $product) {
            $product->save();
        }

        $controller = new ProductsController();

        ob_start();

        $controller->index();
        $response = ob_get_contents();


        ob_end_clean();

        $this->assertMatchesRegularExpression("/{$product->getName()}/", $response);
    }
}
