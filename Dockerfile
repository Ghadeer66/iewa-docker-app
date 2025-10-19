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
# 9. Build assets and fix Vite manifest
# -----------------------------
RUN npm run build \
    && mkdir -p public/build \
    && cp -n public/build/.vite/manifest.json public/build/manifest.json || true

# -----------------------------
# 10. Set Laravel permissions
# -----------------------------
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# -----------------------------
# 11. Expose Railway port
# -----------------------------
EXPOSE 8080

# -----------------------------
# 12. Start PHP server and ensure storage link exists
# -----------------------------
CMD ["sh", "-c", "php artisan storage:link || true && php -S 0.0.0.0:${PORT:-8080} -t public"]
