FROM php:5.6-fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN usermod -u 1000 www-data
RUN usermod -G staff www-data

WORKDIR /var/www/krasctf