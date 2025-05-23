<?php

require '/var/www/app/models/Product.php';

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== 'PUT') {
    header('Location: /pages/products');
    exit;
}


$product = $_POST['product'];

$id = $product['id'];
$name = trim($product['name']);

$product = Product::findById($id);
$product->setName($name);

if ($product->save()) {
    header('Location: /pages/products');
    exit;
} else {
    if ($product->save()) {
        header('Location: /pages/products');
    } else {
        $title = "Atualizar produto #{$id}";
        $view = '/var/www/app/views/products/edit.phtml';
        require '/var/www/app/views/layouts/application.phtml';
    }
}
