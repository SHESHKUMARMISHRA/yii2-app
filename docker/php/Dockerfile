FROM php:8.2-fpm-bullseye

# Force HTTPS for apt (corporate network fix)
RUN sed -i 's|http://deb.debian.org|https://deb.debian.org|g' /etc/apt/sources.list \
 && sed -i 's|http://security.debian.org|https://security.debian.org|g' /etc/apt/sources.list

# Install system dependencies required for GD + FreeType
RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        zip \
        curl \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
