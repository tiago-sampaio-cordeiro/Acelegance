<?php

class Product
{

    const DB_PATH = '/var/www/database/products.txt';

    private array $errors = [];


    public function __construct(
        private int $id = -1,
        public string $name = ''
    ) {}

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function save(): bool
    {
        if ($this->is_valid()) {
            $this->id = count(file(self::DB_PATH));
            file_put_contents(self::DB_PATH, $this->name . PHP_EOL, FILE_APPEND);
            return true;
        }
        return false;
    }

    public function is_valid(): bool
    {
        $this->errors = [];

        if (empty($this->name)) {
            $this->errors['name'] = 'O campo nome do produto não pode ser vazio.';
        }
        return empty($this->errors);
    }

    public function hasErrors(): bool
    {
        return empty($this->errors);
    }

    public function getErrors($index)
    {
        if (isset($this->errors[$index])) {
            return $this->errors[$index];
        }
        return null;
    }
}
