FROM php:8.2-cli

# System dependencies
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    libpq-dev \
    icu-dev \
    oniguruma-dev \
    zlib-dev

# PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    intl \
    mbstring \
    opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files first (better cache)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Copy application source
COPY . .

# Permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
