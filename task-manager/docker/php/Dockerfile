FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev

RUN docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html