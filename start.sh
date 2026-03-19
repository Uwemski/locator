#!/usr//bin/env bash

echo "Running composer"

composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:clear

echo "Caching route"
php artisan route:clear

echo "Publishing cloudinary provider..."
php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"

echo "Running migrations..."
php artisan migrate --force