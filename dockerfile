# Dockerfile
FROM php:8.2-apache

# Update system packages and install security updates
RUN apt-get update && apt-get upgrade -y && apt-get clean

# Install MySQLi extension
RUN docker-php-ext-install mysqli

# Enable Apache rewrite if needed
RUN a2enmod rewrite

# Copy your PHP app
COPY ./app /var/www/html/

# Set working directory
WORKDIR /var/www/html/
