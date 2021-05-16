FROM php:8.0-fpm-alpine

# Install system dependencies
RUN apk update && apk upgrade && apk add --no-cache \
    $PHPIZE_DEPS \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd
