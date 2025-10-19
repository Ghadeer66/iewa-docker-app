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
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# -----------------------------
# 3. Install Node.js (official NodeSource version)
#    This ensures correct binaries for ARM64 / x86_64
# -----------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# -----------------------------
# 4. Install PHP extensions including Redis
# -----------------------------
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && pecl install redis \
    && docker-php-ext-enable redis

# -----------------------------
# 5. Install Composer
# -----------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -----------------------------
# 6. Set working directory
# -----------------------------
WORKDIR /var/www/html

# -----------------------------
# 7. Copy dependency files for caching
# -----------------------------
COPY composer.json composer.lock package.json package-lock.json ./

# -----------------------------
# 8. Install backend + frontend dependencies
# -----------------------------
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Clean node_modules (avoid host architecture leftovers)
RUN rm -rf node_modules

# Install node dependencies fresh (for correct arch)
RUN npm ci

# -----------------------------
# 9. Copy full application
# -----------------------------
COPY . .

# -----------------------------
# 10. Environment setup
# -----------------------------
ENV NODE_ENV=production
ENV APP_ENV=production

# -----------------------------
# 11. Laravel setup and Vite build
# -----------------------------
RUN php artisan package:discover

# Run Vite build for production
RUN npm run build

# -----------------------------
# 12. Set permissions for Laravel
# -----------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && mkdir -p /var/www/html/public/build \
    && chown -R www-data:www-data /var/www/html/public/build \
    && chmod -R g+w /var/www/html/public/build

# -----------------------------
# 13. Expose port
# -----------------------------
EXPOSE 8080

# -----------------------------
# 14. Run Laravel app
# -----------------------------
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t public"]
