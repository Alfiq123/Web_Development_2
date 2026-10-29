# Use the official PHP image with Apache built-in
FROM php:8.2-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Copy your local PHP files into the container's default web directory
# COPY . /var/www/html/
COPY Website/pemrogweb2_1/ /var/www/html/

# Expose port 80 to access the web server
EXPOSE 80
