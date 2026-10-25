# Use the official PHP image with Apache built-in
FROM php:8.2-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy your local PHP files into the container's default web directory
# COPY . /var/www/html/
COPY Website/pemrogweb2_1/ /var/www/html/

# Expose port 80 to access the web server
EXPOSE 80
