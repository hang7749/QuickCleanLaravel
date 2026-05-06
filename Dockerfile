FROM richarvey/nginx-php-fpm:3.1.6

# Set the working directory
WORKDIR /var/www/html

# Copy everything
COPY . .

# Install Composer manually during build
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Image configuration
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false

# Ensure permissions are correct for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Make sure our deploy script is executable
RUN chmod +x /var/www/html/scripts/00-laravel-deploy.sh