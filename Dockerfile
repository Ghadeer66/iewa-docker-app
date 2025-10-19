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
# 3. Install PHP extensions
# -----------------------------
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

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
# 7. Install dependencies without running scripts yet
# -----------------------------
RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN npm ci

# -----------------------------
# 8. Copy full application
# -----------------------------
COPY . .

# -----------------------------
# 9. Run post-install scripts and build assets
# -----------------------------
RUN php artisan package:discover
RUN npm run build

# -----------------------------
# 10. Set permissions for Laravel
# -----------------------------
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# -----------------------------
# 11. Switch to www-data user
# -----------------------------
USER www-data

# -----------------------------
# 12. Expose PHP-FPM port
# -----------------------------
EXPOSE 9000

# -----------------------------
# 13. Start PHP-FPM
# -----------------------------
CMD ["php-fpm"]
