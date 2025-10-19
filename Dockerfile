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
    nginx \
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
# 11. Set permissions for Laravel (fixed syntax)
# -----------------------------
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/public/build \
    && chmod -R 775 /var/www/public/build

# -----------------------------
# 12. Copy Nginx configuration
# -----------------------------
COPY docker/nginx.conf /etc/nginx/sites-available/default

# -----------------------------
# 13. Generate application key and cache config
# -----------------------------
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# -----------------------------
# 14. Expose port
# -----------------------------
EXPOSE 8080

# -----------------------------
# 15. Start script that handles Railway's PORT
# -----------------------------
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
CMD ["/usr/local/bin/start.sh"]
