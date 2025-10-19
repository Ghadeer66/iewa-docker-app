# Base PHP-FPM image
FROM php:8.2-fpm

# -----------------------------
# 1. Install system dependencies
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
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------
# 2. Install PHP extensions
# -----------------------------
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# -----------------------------
# 3. Install Composer
# -----------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -----------------------------
# 4. Set working directory
# -----------------------------
WORKDIR /var/www

# -----------------------------
# 5. Copy project files (first copy only composer.json and package.json)
#    to leverage Docker cache for dependencies
# -----------------------------
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# -----------------------------
# 6. Install Composer and NPM dependencies
# -----------------------------
RUN composer install --no-dev --optimize-autoloader --prefer-dist
RUN npm ci

# -----------------------------
# 7. Copy the rest of the app
# -----------------------------
COPY . .

# -----------------------------
# 8. Build assets (Vite)
# -----------------------------
RUN npm run build

# -----------------------------
# 9. Set proper permissions
# -----------------------------
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# -----------------------------
# 10. Switch to www-data user
# -----------------------------
USER www-data

# -----------------------------
# 11. Expose PHP-FPM port
# -----------------------------
EXPOSE 9000

# -----------------------------
# 12. Start PHP-FPM
# -----------------------------
CMD ["php-fpm"]

