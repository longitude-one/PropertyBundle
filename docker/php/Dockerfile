FROM php:8-fpm-alpine

# LOAD PHP.INI development
# CMD cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

RUN apk --update --no-cache add bash git icu-dev libxslt-dev zip libzip-dev \
        && docker-php-ext-install intl xsl zip \
        && docker-php-ext-enable intl xsl zip

## Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Install symfony
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
    && apk add symfony-cli

COPY php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www

## Install our bundle
## Start Symfony local server

## Install the libraries
CMD composer install ; \
    symfony console assets:install ; \
    symfony server:stop --dir /var/www/tests/App/public ; \
    symfony server:start --dir /var/www/tests/App/public

EXPOSE 8000
