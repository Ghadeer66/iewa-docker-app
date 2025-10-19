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
# 9. Copy storage images explicitly
# -----------------------------
COPY storage/app/public/images /var/www/storage/app/public/images
COPY storage/app/public/images/food-types /var/www/storage/app/public/images/food-types
COPY storage/app/public/images/food-categories /var/www/storage/app/public/images/food-categories
COPY storage/app/public/meals /var/www/storage/app/public/meals

# -----------------------------
# 10. Run post-install scripts, build assets, create storage symlink
# -----------------------------
RUN php artisan package:discover
RUN npm run build \
    && cp public/build/.vite/manifest.json public/build/manifest.json
RUN php artisan storage:link || true

# -----------------------------
# 11. Set permissions for Laravel
# -----------------------------
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# -----------------------------
# 12. Expose Railway port
# -----------------------------
EXPOSE 8080

# -----------------------------
# 13. Start PHP built-in server on Railway $PORT
# -----------------------------
#    If $PORT is not set, default to 8080
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t public"]
