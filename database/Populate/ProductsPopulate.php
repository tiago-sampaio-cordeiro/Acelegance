<?php

namespace Database\Populate;

use App\Models\Product;

class ProductsPopulate {
    public static function populate() {
        $numberOfProducts = 100;

        for ($i = 0; $i < $numberOfProducts; $i++) {
            $product = new Product(name: 'Product ' . $i);
            $product->save();
           
        }

        echo "Populated $numberOfProducts products.\n";
    } 
}