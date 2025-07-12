FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy app source code
COPY . .

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Expose port 8080 for Render
EXPOSE 8080

# Configure Apache to serve Laravel
RUN echo '<Directory /var/www/html/public>
    AllowOverride All
</Directory>' > /etc/apache2/conf-available/allow-override.conf \
    && a2enconf allow-override

# Start Apache in the foreground
CMD ["apache2-foreground"]
