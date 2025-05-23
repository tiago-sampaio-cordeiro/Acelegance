<?php

$id = intval($_GET['id']);

define('DB_PATH', '/var/www/database/products.txt');

$products = file(DB_PATH, FILE_IGNORE_NEW_LINES);

$product['name'] = $products[$id];

$title = "Detalhes do Produto #{$id}";

$view = '/var/www/app/views/products/show.phtml';

require '/var/www/app/views/layouts/application.phtml';
