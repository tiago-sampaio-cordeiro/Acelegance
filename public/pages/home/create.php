<?php

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    header('Location: /pages/home');
    exit;
}

$errors = [];

$name = $_POST['full_name']['full-name'] ?? '';
$email = $_POST['email']['email-register'] ?? '';
$senha = $_POST['senha']['senha-register'] ?? '';

// Validação
if (empty(trim($name))) {
    $errors['full-name'] = 'Nome é obrigatório.';
}
if (empty(trim($email))) {
    $errors['email-register'] = 'E-mail é obrigatório.';
}
if (empty(trim($senha))) {
    $errors['senha-register'] = 'Senha é obrigatória.';
}

if (empty($errors)) {
    define('DB_PATH', '/var/www/database/users.txt');

    $entry = trim($name) . ' | ' . trim($email) . ' | ' . trim($senha) . PHP_EOL;

    file_put_contents(DB_PATH, $entry, FILE_APPEND);
    header('Location: /pages/home');
} else {
    $title = 'Cadastro de usuário';

    $view = '/var/www/app/views/home/new.phtml';

    require '/var/www/app/views/layouts/application.phtml';
}
