<?php

require '/var/www/app/models/Product.php';

$products = Product::all();



// define('DB_PATH', '/var/www/database/products.txt');

// $products = file(DB_PATH, FILE_IGNORE_NEW_LINES);

$title = "Produtos";

$view = '/var/www/app/views/products/index.phtml';

require '/var/www/app/views/layouts/application.phtml';
