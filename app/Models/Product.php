<?php

namespace App\Models;

use Core\Constants\Constants;

class Product
{
    /**
     * @var array<string, string>
     */
    private array $errors = [];


    public function __construct(
        private int $id = -1,
        public string $name = ''
    ) {
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function save(): bool
    {
        if ($this->isValid()) {
            if ($this->newRecord()) {
                $this->id = file_exists(self::dbPath()) ? count(file(self::dbPath())) : 0;
                file_put_contents(self::dbPath(), $this->name . PHP_EOL, FILE_APPEND);
            } else {
                $products = file(self::dbPath(), FILE_IGNORE_NEW_LINES);
                $products[$this->id] = $this->name;

                $data = implode(PHP_EOL, $products);
                file_put_contents(self::dbPath(), $data . PHP_EOL);
            }
            return true;
        }
        return false;
    }

    public function delete(): void
    {
        $products = file(self::dbPath(), FILE_IGNORE_NEW_LINES);
        unset($products[$this->id]);

        $data = implode(PHP_EOL, $products);
        file_put_contents(self::dbPath(), $data . PHP_EOL);
    }


    public function isValid(): bool
    {
        $this->errors = [];

        if (empty($this->name)) {
            $this->errors['name'] = 'O campo nome do produto não pode ser vazio.';
        }
        return empty($this->errors);
    }

    public function newRecord(): bool
    {
        return $this->id === -1;
    }

    public function hasErrors(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(string $index): string|null
    {
        if (isset($this->errors[$index])) {
            return $this->errors[$index];
        }
        return null;
    }

    /**
     * @return array<int, Product>
     */

    public static function all(): array
    {
        if (!file_exists(self::dbPath())) {
            return [];
        }
        $products = array_values(file(self::dbPath(), FILE_IGNORE_NEW_LINES));

        return array_filter(array_map(function ($name, $index) {
            return new Product(
                id: $index,
                name: $name
            );
        }, $products, array_keys($products)), function ($product) {
            return trim($product->getName()) !== '';
        });
    }




    public static function findById(int $id): Product|null
    {

        $products = self::all();

        foreach ($products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null;
    }

    private static function dbPath(): string
    {
        return Constants::databasePath()->join($_ENV['DB_NAME']);
    }
}
