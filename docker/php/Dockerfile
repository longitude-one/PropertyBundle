FROM php:8-fpm-alpine

#LOAD PHP.INI development
#CMD cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

## remove openssh-client when PR dmish-setting is accepted
RUN apk --update --no-cache add bash git openssh-client postgresql-dev icu-dev libxslt-dev zip libzip-dev \
        && docker-php-ext-install pdo_pgsql intl opcache xsl zip \
        && docker-php-ext-enable pdo_pgsql intl opcache xsl zip

## Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Install symfony
RUN wget https://get.symfony.com/cli/installer -O /tmp/installer && \
    chmod a+x /tmp/installer && \
    /tmp/installer --install-dir=/usr/local/bin/ && \
    rm /tmp/installer

#APCU
#RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
#        && pecl install apcu \
#        && docker-php-ext-enable apcu \
#        && pecl clear-cache \
#        && apk del .build-dependencies

#XSL because this conf file doesn't want to activate it
#COPY xsl.ini /usr/local/etc/php/conf.d/xsl.ini
COPY php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www

## Install our bundle
## Install PHP-CS-FIXER as an another tools to avoid to complexify our needed dev libraries
## Start Symfony local server
CMD composer install ; \
    symfony server:start --dir /var/www/tests/App/public

EXPOSE 8000
