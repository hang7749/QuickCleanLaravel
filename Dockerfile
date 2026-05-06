# Stage 1: Build the vendor folder
FROM composer:latest as build
WORKDIR /app
COPY . .
# We ignore platform reqs here just to ensure the build finishes
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Stage 2: Final Web Server (Using PHP 8.4)
FROM php:8.4-fpm-alpine

# Install Nginx and system dependencies
RUN apk add --no-cache nginx wget

# Install PHP extensions needed for Laravel
RUN docker-php-ext-install bcmath opcache

# Setup Working Directory
WORKDIR /var/www/html

# Copy project and vendor
COPY . .
COPY --from=build /app/vendor /var/www/html/vendor

# Setup Nginx Configuration
COPY .docker/nginx.conf /etc/nginx/http.d/default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start Nginx and PHP-FPM
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]