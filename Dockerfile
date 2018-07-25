FROM composer:1.6

RUN apk add make
COPY dev.ini /usr/local/etc/php/conf.d/z-dev.ini
