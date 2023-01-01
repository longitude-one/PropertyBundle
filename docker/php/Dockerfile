FROM php:8-fpm-alpine

RUN apk --update --no-cache add bash git icu-dev libxslt-dev zip libzip-dev \
        && docker-php-ext-install intl xsl zip \
        && docker-php-ext-enable intl xsl zip \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
        && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
        && apk add symfony-cli

##        && cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

COPY php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www

## Install our bundle
## Install assets
## Stop then start Symfony local server
CMD composer install ; \
    symfony console assets:install ; \
    symfony server:stop --dir /var/www/tests/App/public ; \
    symfony server:start --dir /var/www/tests/App/public

EXPOSE 8000
