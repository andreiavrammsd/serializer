ARG PHPVERSION
FROM php:$PHPVERSION-cli-alpine3.10

RUN curl -s http://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    apk add --update --no-cache make alpine-sdk autoconf && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apk del alpine-sdk autoconf

COPY dev/dev.ini /usr/local/etc/php/conf.d/z-dev.ini

WORKDIR /src
