<?php

require '/var/www/app/models/Product.php';

$products = Product::all();

$title = "Produtos";

$view = '/var/www/app/views/products/index.phtml';

require '/var/www/app/views/layouts/application.phtml';
