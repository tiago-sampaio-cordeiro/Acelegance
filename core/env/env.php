<?php

$envs = parse_ini_file('/var/www/.env');

foreach ($envs as $key => $value) {
    if (!isset($_ENV[$key])) {
        $_ENV[$key] = $value;
    }
}
