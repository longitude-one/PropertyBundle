<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

// if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
// } elseif (method_exists(Dotenv::class, 'bootEnv')) {
// (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
// }

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

include '../vendor/autoload.php';
