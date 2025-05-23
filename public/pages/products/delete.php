<?php

require '/var/www/app/models/Product.php';

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== 'DELETE') {
    header('Location: /pages/products');
    exit;
}

$param = $_POST['product'];
$product = Product::findById($param['id']);

// pode ser usado assim tambem
// $product = Product::findById(_POST['product']['id']););


if ($product) {
    $product->delete();
    header('Location: /pages/products');
    exit;
} else {
    // opcional: log, erro, ou redirecionamento
    header('Location: /pages/products?error=not_found');
    exit;
}
