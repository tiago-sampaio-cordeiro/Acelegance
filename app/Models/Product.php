<?php

namespace App\Models;

use Core\Database\Database;

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
            $pdo = Database::getDatabaseConn();
            if ($this->newRecord()) {
                $sql = 'INSERT INTO products (name) VALUES (:name)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $this->name);

                $stmt->execute();
                $this->id = (int)$pdo->lastInsertId();
            } else {
                $sql = 'UPDATE products SET name = :name WHERE id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
            }
            return true;
        }
        return false;
    }

    public function delete(): bool
    {
        $pdo = Database::getDatabaseConn();
        $sql = 'DELETE FROM products WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return ($stmt->rowCount() !== 0);
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
        $products = [];

        $pdo = Database::getDatabaseConn();
        $resp =  $pdo->query('SELECT id, name FROM products');

        foreach ($resp as $row) {
            $products[] = new Product(
                id: (int)$row['id'],
                name: $row['name']
            );
        }
        return $products;
    }




    public static function findById(int $id): Product|null
    {
        $pdo = Database::getDatabaseConn();

        $sql = 'SELECT id, name FROM products WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return null;
        }
        $row = $stmt->fetch();
        return new Product(
            id: (int)$row['id'],
            name: $row['name']
        );
    }
}
