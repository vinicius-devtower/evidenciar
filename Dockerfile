FROM php:8.3-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer