# Use the official PHP 8.0 image as a parent image
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    libsqlite3-dev

# Install PDO Extension for SQLite
RUN docker-php-ext-install pdo pdo_sqlite

# Install the PHP sockets extension
RUN docker-php-ext-install pdo pdo_mysql sockets

# Set the working directory in the container
WORKDIR /var/www

# Copy the current directory contents into the container at /var/www
COPY ./ /var/www

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1


# Install dependencies with Composer
RUN composer install

# Expose port 8000 to the outside world
EXPOSE 8000

# Command to run the server
CMD php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000
