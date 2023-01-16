<?php

//DotEnv does not exist, tests doesn't need these four lines.

//if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
//} elseif (method_exists(Dotenv::class, 'bootEnv')) {
//(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
//}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

include '../vendor/autoload.php';
