# Bundle template

This package is a bundle template to help you to:
* create a new bundle 
* with a dummy controller (feel free to delete it)
* with an embedded application to test your bundle
* with phpunit unit test on a dummy controller (feel free to delete this test)
* with phpunit function test on this dummy controller (feel free to delete this test)
* with phpcsfixer deployed as an external tool

## Installation with Docker
A very simple docker is embedded to:
* provide you a PHP8.1 environment
* provide you composer, symfony and phpcsfixer as external tools
* launch local symfony server to help you to dev

First, edit the .env file and update the two parameters.

Then simply build your container:
````shell
docker-compose up --build
````
With your browser, you can access the provided dummy controller by accessing the symfony local server http://127.0.0.1/

# Installation without docker
If you dislike docker, you can install all this stuff with the following commands, but you need to install PHP, composer
and Symfony on your system.
````shell
## Install the needed libraries
composer install
## Install PHP-CS-FIXER
composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer
## Start the localserver. You can access it via http://127.0.0.1:8000/
symfony server:start --dir /var/www/tests/App/public
````

# How to test your bundle?
Your new bundle is created and ready to be test (replace my_bundle-php with the name of your php container):
````shell
docker exec my_bundle-php ./vendor/bin/phpunit
````
If you don't use docker:
````shell
./vendor/bin/phpunit
````

# How to fix your code and add a copyright on your files?
This package comes with a configured phpcsfixer. The configuration is set to respect the @Symfony rules and add a header
on your files :)

First, edit the `tools/headers.txt` file.

Optionally, edit the `tools/php-cs-fixer/.php-cs-fixer.php`.

PHP-CS-FIXER is now set :)

````shell
docker exec my_bundle-php tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src --config=tools/php-cs-fixer/.php-cs-fixer.php
docker exec my_bundle-php tools/php-cs-fixer/vendor/bin/php-cs-fixer fix tests --config=tools/php-cs-fixer/.php-cs-fixer.php
````
If you don't use docker:
````shell
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src --config=tools/php-cs-fixer/.php-cs-fixer.php
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix tests --config=tools/php-cs-fixer/.php-cs-fixer.php
````
