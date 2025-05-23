<?php

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== 'PUT') {
    header('Location: /pages/products');
    exit;
}


$product = $_POST['product'];

$id = $product['id'];
$name = trim($product['name']);

$errors = [];
if (empty($name)) {
    $errors['name'] = 'O campo nome do produto não pode ser vazio.';
}

if (empty($errors)) {
    define('DB_PATH', '/var/www/database/products.txt');

    $products = file(DB_PATH, FILE_IGNORE_NEW_LINES);

    $products[$id] = $name;
    $data = implode(PHP_EOL, $products);

    file_put_contents(DB_PATH, $data . PHP_EOL);

    header('Location: /pages/products');
} else {
    $title = "Atualizar produto #{$id}";

    $view = '/var/www/app/views/products/edit.phtml';

    require '/var/www/app/views/layouts/application.phtml';
}
