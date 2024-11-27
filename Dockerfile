FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copy existing application directory contents
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Expose port 9003 for Xdebug
EXPOSE 9003
