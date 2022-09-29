# Property Bundle

## Bundle under development, do not use.

## Install

```shell
composer require longitude-one/property-bundle
``` 

## Contributing

Clone project
```shell
git clone https://github.com/longitude-one/PropertyBundle.git
cd PropertyBundle
```

Install vendor libraries
```shell
docker run --init -it --rm -v "$(pwd):/project" -v "$(pwd)/tmp-phpqa:/tmp" -w /project jakzal/phpqa composer update
```

Test project
```shell
docker run --init -it --rm -v "$(pwd):/project" -v "$(pwd)/tmp-phpqa:/tmp" -w /project jakzal/phpqa php -d pcov.enabled=1 ./vendor/bin/phpunit --coverage-html ./.coverage/ 
```

Test code syntax
```shell
docker run --init -it --rm -v "$(pwd):/project" -v "$(pwd)/tmp-phpqa:/tmp" -w /project jakzal/phpqa php-cs-fixer fix --config=tools/php-cs-fixer/.php-cs-fixer.php --allow-risky=yes
```

Test code quality
```shell
docker run --init -it --rm -v "$(pwd):/project" -v "$(pwd)/tmp-phpqa:/tmp" -w /project jakzal/phpqa phpstan analyse src tests --configuration tools/php-stan/php-stan.neon -l 9
```

