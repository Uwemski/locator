FROM php:8.2-cli

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chmod -R 755 storage bootstrap/cache

# Expose the correct port for Render
EXPOSE 8080

# Use Laravel's public directory as root
CMD php -S 0.0.0.0:$PORT -t public
