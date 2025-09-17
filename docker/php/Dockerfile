FROM php:8.3-fpm

# System deps
RUN apt-get update && apt-get install -y     git unzip libpq-dev libzip-dev libicu-dev libonig-dev libxml2-dev     libpng-dev libjpeg-dev libfreetype6-dev libssl-dev     && docker-php-ext-configure gd --with-freetype --with-jpeg     && docker-php-ext-install pdo pdo_mysql zip intl gd     && pecl install redis     && docker-php-ext-enable redis

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
