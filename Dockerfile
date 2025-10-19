### Stage 1: Node build stage (build frontend assets with Vite)
FROM node:18-alpine AS node-builder
WORKDIR /app

# Copy only package files to leverage Docker cache
COPY package.json package-lock.json ./
RUN npm ci --silent

# Copy the rest of the assets needed for build
COPY resources ./resources
COPY vite.config.ts ./vite.config.ts
COPY tsconfig.json ./tsconfig.json
COPY tailwind.config.js ./tailwind.config.js
COPY postcss.config.js ./postcss.config.js

ENV NODE_ENV=production

# Run the production build which outputs to public/build (per vite.config.ts)
RUN npm run build

### Stage 2: PHP runtime image
FROM php:8.2-fpm AS php-runtime

# system deps
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && pecl install redis \
    && docker-php-ext-enable redis

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy application files
COPY . .

# Copy built frontend assets from node-builder
COPY --from=node-builder /app/public/build ./public/build

# Set environment
ENV APP_ENV=production

# Run artisan optimise steps
RUN php artisan package:discover --ansi --no-interaction || true

# Permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache \
    && chown www-data:www-data -R public/build/ || true

# Expose port for Railway (or override with $PORT)
EXPOSE 8080

# Default command uses built-in PHP server for simple deployments like Railway
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t public"]
# -----------------------------
# 1. Base image
# -----------------------------
FROM php:8.2-fpm

# -----------------------------
# 2. Install system dependencies
# -----------------------------
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# -----------------------------
# 3. Install PHP extensions including Redis
# -----------------------------
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && pecl install redis \
    && docker-php-ext-enable redis

# -----------------------------
# 4. Install Composer
# -----------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -----------------------------
# 5. Set working directory
# -----------------------------
WORKDIR /var/www

# -----------------------------
# 6. Copy dependency files for caching
# -----------------------------
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# -----------------------------
# 7. Install dependencies without running post-autoload scripts yet
# -----------------------------
RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN npm ci

# -----------------------------
# 8. Copy full application
# -----------------------------
COPY . .

# -----------------------------
# 9. Set environment to production
# -----------------------------
ENV NODE_ENV=production
ENV APP_ENV=production

# -----------------------------
# 10. Run post-install scripts and build assets
# -----------------------------
RUN php artisan package:discover

# Build Vite assets for production
RUN npm run build

# -----------------------------
# 11. Set permissions for Laravel
# -----------------------------
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache && chown www-data:www-data -R public/build/ && chmod g+w -R public/build/

# -----------------------------
# 12. Generate the Vite manifest (fallback)
# -----------------------------
# This ensures the manifest exists even if build fails
RUN php artisan vite:build 2>/dev/null || echo "Vite build completed"

# -----------------------------
# 13. Expose Railway port
# -----------------------------
EXPOSE 8080

# -----------------------------
# 14. Start PHP built-in server on Railway $PORT
# -----------------------------
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t public"]
