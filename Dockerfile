FROM richarvey/nginx-php-fpm:3.1.6

# Copy all project files
COPY . .

# Image configuration
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel production optimizations
ENV APP_ENV production
ENV APP_DEBUG false

# Expose port 80
EXPOSE 80

# Run a custom script on startup to clear cache
RUN chmod +x /var/www/html/scripts/00-laravel-deploy.sh