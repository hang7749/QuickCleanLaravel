# Stage 1: Build the vendor folder
FROM composer:2 as build
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Stage 2: Final Web Server
FROM richarvey/nginx-php-fpm:3.1.6
WORKDIR /var/www/html

# Copy everything from our local folder
COPY . .

# Copy the VENDOR folder specifically from the build stage
COPY --from=build /app/vendor /var/www/html/vendor

# Configuration
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false

# Permissions
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
RUN chmod +x /var/www/html/scripts/00-laravel-deploy.sh