FROM php:8.1-fpm

RUN docker-php-ext-install pdo pdo_mysql pgsql pdo_pgsql
WORKDIR /var/www/html
COPY ../application/ .
RUN chown -R www-data:www-data /var/www/html

