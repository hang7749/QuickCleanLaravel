FROM richarvey/nginx-php-fpm:3.1.6

# Copy all project files
COPY . .

# Image configuration
# We change SKIP_COMPOSER to 0 so it actually installs your dependencies
ENV SKIP_COMPOSER 0
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel production optimizations
ENV APP_ENV production
ENV APP_DEBUG false

# Allow Composer to run as root (needed for Docker builds)
ENV COMPOSER_ALLOW_SUPERUSER 1

# Expose port 80
EXPOSE 80

# Fix permissions so the webserver can write to storage
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Run the deploy script
RUN chmod +x /var/www/html/scripts/00-laravel-deploy.sh