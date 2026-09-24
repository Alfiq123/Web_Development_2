# Use the official PHP image with Apache built-in
FROM php:8.2-apache

# Copy your local PHP files into the container's default web directory
# COPY . /var/www/html/
COPY Website/pemrogweb2_1/ /var/www/html/

# Expose port 80 to access the web server
EXPOSE 80

# Copy configuration, whatever
COPY Website/pemrogweb2_1/custom-php.ini /usr/local/etc/php/conf.d/custom.ini