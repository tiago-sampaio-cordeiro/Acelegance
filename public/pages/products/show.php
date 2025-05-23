<?php

require '/var/www/app/models/Product.php';

$id = intval($_GET['id']);

$product = Product::findById($id);

$title = "Detalhes do Produto #{$id}";

$view = '/var/www/app/views/products/show.phtml';

require '/var/www/app/views/layouts/application.phtml';
