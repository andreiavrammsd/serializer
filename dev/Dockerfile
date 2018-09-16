FROM php:7.2-cli-alpine3.8

RUN wget \
    https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer \
    -O - -q | php -- --quiet \
    && mv composer.phar /usr/local/bin/composer

RUN apk add make

COPY dev/dev.ini /usr/local/etc/php/conf.d/z-dev.ini

WORKDIR /src
