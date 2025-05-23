<?php

require '/var/www/app/models/Product.php';

$id = intval($_GET['id']);

$product = Product::findById($id);

$title = "Atualizar produto #{$id}";

$view = '/var/www/app/views/products/edit.phtml';

require '/var/www/app/views/layouts/application.phtml';
