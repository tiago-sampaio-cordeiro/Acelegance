<?php

require '/var/www/app/models/Product.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    header('Location: /pages/products');
    exit;
}

$params = $_POST['product'];


$product = new Product(name: $params['name']);

if ($product->save()) {
    header('Location: /pages/products');
    exit;
} else {
    $title = 'Cadastro de Produtos';
    $view = '/var/www/app/views/products/new.phtml';
    require '/var/www/app/views/layouts/application.phtml';
}
