FROM php:8.3-fpm-alpine

WORKDIR /var/www/tinder

RUN docker-php-ext-install pdo pdo_mysql