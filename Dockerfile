# Use the official PHP image
FROM php:8.2.11-fpm

# Install necessary system dependencies and PHP extensions, including zip
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    apt-utils \
    nano \
    wget \
    dialog \
    vim \
    build-essential \
    git \
    curl \
    libcurl4 \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libzip-dev \
    zip \
    libbz2-dev \
    locales \
    libmcrypt-dev \
    libicu-dev \
    libonig-dev \
    nodejs \
    npm \
    libxml2-dev \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql exif gd zip \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Set the working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Run composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set appropriate permissions for the cache and storage directories
RUN mkdir -p /var/www/bootstrap/cache /var/www/storage \
    && chown -R www-data:www-data /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache /var/www/storage

# Install Node.js (v20 or v22) and npm (latest version)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && npm install

# Copy supervisor configuration
COPY ./docker-compose/supervisor/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Expose the port
EXPOSE 9000

# Start PHP-FPM
# CMD ["php-fpm"]
CMD ["/usr/bin/supervisord", "-n"]

