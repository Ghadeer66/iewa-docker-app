# -----------------------------
# 1. Frontend build stage
# -----------------------------
FROM node:20-bullseye AS frontend

WORKDIR /var/www/html

# Copy only files needed for dependency installation
COPY package*.json ./

# Install frontend dependencies
RUN npm ci

# Copy the rest of the code and build
COPY . .
RUN npm run build


# -----------------------------
# 2. PHP application stage
# -----------------------------
FROM php:8.2-fpm

# Install PHP and system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions + Redis
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && pecl install redis \
    && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy app source
COPY . .

# Copy built frontend from the Node stage
COPY --from=frontend /var/www/html/public /var/www/public
COPY --from=frontend /var/www/html/node_modules /var/www/node_modules

ENV APP_ENV=production
ENV NODE_ENV=production

RUN php artisan package:discover

# Fix permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache \
    && mkdir -p public/build && chown -R www-data:www-data public/build

EXPOSE 8080

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t public"]
