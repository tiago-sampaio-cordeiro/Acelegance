<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Debug\Debugger;

class ProductsController
{
    public function index(): void
    {

        $products = Product::all();
        Debugger::dd($products, Product::class);

        $title = "Produtos";

        $this->render('index', compact('products', 'title'));
    }

    public function show(): void
    {
        $id = intval($_GET['id']);

        $product = Product::findById($id);

        $title = "Detalhes do Produto #{$id}";

        $this->render('show', compact('product', 'title'));
    }


    public function new(): void
    {
        $title = 'Cadastro de Produtos';

        $view = '/var/www/app/views/products/new.phtml';

        $product = new Product();

        $this->render('new', compact('product', 'title'));
    }

    public function create(): void
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

    public function edit(): void
    {
        $id = intval($_GET['id']);

        $product = Product::findById($id);

        $title = "Edição do Produto #{$id}";

        $this->render('edit', compact('product', 'title'));
    }

    public function update(): void
    {

        $method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

        if ($method !== 'PUT') {
            $this->redirectTo('/pages/products');
        }


        $params = $_POST['product'];

        $product = Product::findById($params['id']);
        $product->setName($params['name']);

        $result = $product->save();

        if ($result) {
            $this->redirectTo('/pages/products');
        } else {
            $title = "Atualizar produto #{$product->getId()}";
            $this->render('edit', compact('product', 'title'));
        }
    }

    public function destroy(): void
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

    /**
     * @param array<string, mixed> $data
     */
    private function render(string $view, array $data = []): void
    {

        extract($data);
        $view = '/var/www/app/views/products/' . $view . '.phtml';
        require '/var/www/app/views/layouts/application.phtml';
    }

    private function redirectTo(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
