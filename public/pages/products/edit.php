<?php

$id = intval($_GET['id']);

define('DB_PATH', '/var/www/database/products.txt');

$products = file(DB_PATH, FILE_IGNORE_NEW_LINES);

$product['id'] = $id;
$product['name'] = $products[$id];

$title = "Atualizar produto #{$id}";

$view = '/var/www/app/views/products/edit.phtml';

require '/var/www/app/views/layouts/application.phtml';
