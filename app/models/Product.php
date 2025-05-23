<?php

class Product
{

    const DB_PATH = '/var/www/database/products.txt';

    private array $errors = [];


    public function __construct(
        private int $id = -1,
        public string $name = ''
    ) {}

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(): string
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function save(): bool
    {

        file_put_contents(self::DB_PATH, $this->name . PHP_EOL, FILE_APPEND);
        return true;
    }
}
