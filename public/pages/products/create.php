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
} else {
    $title = 'Cadastro de Produtos';
    $view = '/var/www/app/views/products/new.phtml';
    require '/var/www/app/views/layouts/application.phtml';
}


// $product = $_POST['product'];
// $name = trim($product['name']);

// $errors = [];
// if (empty($name)) {
//     $errors['name'] = 'O campo nome do produto não pode ser vazio.';
// }

// if (empty($errors)) {
//     define('DB_PATH', '/var/www/database/products.txt');
//     file_put_contents(DB_PATH, $name . PHP_EOL, FILE_APPEND);
//     header('Location: /pages/products');
// } else {
//     $title = 'Cadastro de Produtos';
//     $view = '/var/www/app/views/products/new.phtml';
//     require '/var/www/app/views/layouts/application.phtml';
// }
