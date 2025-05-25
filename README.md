# Acelegance

Acelegance is an application for jewelry retailers...

### Dependências

- Docker
- Docker Compose

### To run

#### Clone Repository

```
$ https://github.com/tiago-sampaio-cordeiro/Acelegance.git
$ cd Acelegance
```

#### Define the env variables

```
$ cp .env.example .env
```

#### Install the dependencies

```
$ docker compose run --rm composer install
```

#### Up the containers

```
$ docker compose up -d
```

ou

```
$ ./run up -d
```

#### Run the tests

```
$ docker compose run --rm php ./vendor/bin/phpunit tests --color
```

ou

```
$ ./run test
```

Run the Linters

```
$ ./run phpcs
```

```
$ ./run phpstan
```

Access [localhost](http://localhost)

<!--
#### Create database and tables

```
$ ./run db:reset
```

#### Populate database

```
$ ./run db:populate
```

### Fixed uploads folder permission

```
sudo chown www-data:www-data public/assets/uploads -->

```

```
