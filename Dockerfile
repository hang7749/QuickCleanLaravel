# Stage 1: Build the vendor folder
FROM composer:latest as build
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Stage 2: Final Web Server (Using PHP 8.4)
FROM php:8.4-fpm-alpine

# Install System Dependencies & PostgreSQL Dev libraries
RUN apk add --no-cache \
    nginx \
    postgresql-dev \
    libpq

# Install the PHP PostgreSQL drivers
RUN docker-php-ext-install pdo pdo_pgsql bcmath opcache

# Setup Working Directory
WORKDIR /var/www/html

# Copy project and vendor
COPY . .
COPY --from=build /app/vendor /var/www/html/vendor

# Setup Nginx Configuration
COPY .docker/nginx.conf /etc/nginx/http.d/default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]