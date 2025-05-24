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
sudo chown www-data:www-data public/assets/uploads
```

#### Run the tests

```
$ docker compose run --rm php ./vendor/bin/phpunit tests --color
```

Access [localhost](http://localhost)
