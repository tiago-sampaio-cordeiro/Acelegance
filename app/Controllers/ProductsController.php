<?php

namespace App\Controllers;

use App\Models\Product;

class ProductsController
{
    private string $layout = 'application';

    public function index()
    {

        $products = Product::all();

        $title = "Produtos";

        $this->render('index', compact('products', 'title'));
    }

    public function show()
    {
        $id = intval($_GET['id']);

        $product = Product::findById($id);

        $title = "Detalhes do Produto #{$id}";

        $this->render('show', compact('product', 'title'));
    }


    public function new()
    {
        $title = 'Cadastro de Produtos';

        $view = '/var/www/app/views/products/new.phtml';

        $product = new Product();

        $this->render('new', compact('product', 'title'));
    }

    public function create()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method !== 'POST') {
            $this->redirectTo('/pages/products');
        }

        $params = $_POST['product'];
        $product = new Product(name: $params['name']);

        if ($product->save()) {
            $this->redirectTo('/pages/products');
        } else {
            $title = 'Cadastro de Produtos';
            $this->render('new', compact('product', 'title'));
        }
    }

    public function edit()
    {
        $id = intval($_GET['id']);

        $product = Product::findById($id);

        $title = "Edição do Produto #{$id}";

        $this->render('edit', compact('product', 'title'));
    }

    public function update()
    {

        $method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

        if ($method !== 'PUT') {
            $this->redirectTo('/pages/products');
        }


        $params = $_POST['product'];

        $product = Product::findById($params['id']);
        $product->setName($params['name']);

        if ($product->save()) {
            $this->redirectTo('/pages/products');
        } else {
            if ($product->save()) {
                header('Location: /pages/products');
            } else {
                $title = "Atualizar produto #{$product->getId()}";
                $this->render('edit', compact('product', 'title'));
            }
        }
    }

    public function destroy()
    {
        $method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

        if ($method !== 'DELETE') {
            $this->redirectTo('/pages/products');
        }

        $param = $_POST['product'];
        $product = Product::findById($param['id']);

        if ($product) {
            $product->delete();
            $this->redirectTo('/pages/products');
        }
    }


    private function render($view, $data = [])
    {

        extract($data);
        $view = '/var/www/app/views/products/' . $view . '.phtml';
        require '/var/www/app/views/layouts/application.phtml';
    }

    private function redirectTo($location)
    {
        header('Location: ' . $location);
        exit;
    }
}
