<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Debug\Debugger;
use Core\Http\Request;

class ProductsController
{
    public function index(): void
    {

        $products = Product::all();

        $title = "Produtos";

        $this->render('index', compact('products', 'title'));
    }

    public function show(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);

        $title = "Detalhes do Produto #{$product->getId()}";

        $this->render('show', compact('product', 'title'));
    }


    public function new(): void
    {
        $title = 'Cadastro de Produtos';

        $view = '/var/www/app/views/products/new.phtml';

        $product = new Product();

        $this->render('new', compact('product', 'title'));
    }

    public function create(Request $request): void
    {

        $params = $request->getParams();
        $product = new Product(name: $params['product']['name']);

        if ($product->save()) {
            $this->redirectTo(route('products.index'));
        } else {
            $title = 'Cadastro de Produtos';
            $this->render('new', compact('product', 'title'));
        }
    }

    public function edit(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);


        $title = "Edição do Produto #{$product->getId()}";

        $this->render('edit', compact('product', 'title'));
    }

    public function update(Request $request): void
    {

        $params = $request->getParams();

        $product = Product::findById($params['id']);
        $product->setName($params['product']['name']);

        if ($product->save()) {
            $this->redirectTo(route('products.index'));
        } else {
            $title = "Edição do Produto #{$product->getId()}";
            $this->render('edit', compact('product', 'title'));
        }
    }

    public function destroy(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);


        if ($product) {
            $product->delete();
            $this->redirectTo(route('products.index'));
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
