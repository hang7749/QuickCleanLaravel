#!/usr/bin/env bash
echo "Running deployment scripts..."
php artisan config:cache
php artisan route:cache
php artisan view:cache