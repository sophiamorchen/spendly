FROM php:8.2.35-apache

RUN docker-php-ext-install pdo pdo_mysql

# pecl est l'outil qui télécharge des extensions php
RUN pecl install xdebug && docker-php-ext-enable xdebug