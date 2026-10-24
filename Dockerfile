FROM php:8.2.35-apache

RUN docker-php-ext-install pdo pdo_mysql