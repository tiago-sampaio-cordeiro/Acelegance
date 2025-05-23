<?php
require '/var/www/app/models/Product.php';

$title = 'Cadastro de Produtos';

$view = '/var/www/app/views/products/new.phtml';

$product = new Product();

require '/var/www/app/views/layouts/application.phtml';
