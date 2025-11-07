FROM php:8.2-apache

# Enable Apache modules needed by Laravel's .htaccess
RUN a2enmod rewrite

# Install system dependencies and PHP extensions (including ext-zip)
RUN apt-get update && apt-get install -y \
        libzip-dev \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip gd pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer from the official image
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Point Apache's DocumentRoot to Laravel's public directory
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Copy composer manifests separately for better Docker caching
COPY composer.json composer.lock ./

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP dependencies for production (skip scripts until code is copied)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Copy the full application codebase
COPY . .

# Run Composer scripts now that artisan is available
RUN composer run-script post-autoload-dump

# Ensure Laravel can write to its storage directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]

