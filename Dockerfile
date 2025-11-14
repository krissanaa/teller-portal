FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN if [ -f /etc/apt/sources.list ]; then \
        sed -i 's|http://deb.debian.org|https://deb.debian.org|g;s|http://security.debian.org|https://security.debian.org|g' /etc/apt/sources.list; \
    fi \
    && if [ -f /etc/apt/sources.list.d/debian.sources ]; then \
        sed -i 's|http://deb.debian.org|https://deb.debian.org|g;s|http://security.debian.org|https://security.debian.org|g' /etc/apt/sources.list.d/debian.sources; \
    fi \
    && apt-get update && apt-get install -y \
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

WORKDIR /var/www/html

# Install PHP dependencies
COPY composer.json composer.lock ./
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Copy application code
COPY . .
RUN composer run-script post-autoload-dump

# Ensure writable directories for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm", "-F"]
