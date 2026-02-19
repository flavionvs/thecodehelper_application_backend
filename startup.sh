#!/bin/bash

# Increase PHP upload limits
sed -i 's/upload_max_filesize = .*/upload_max_filesize = 50M/' /usr/local/etc/php/php.ini-production
sed -i 's/post_max_size = .*/post_max_size = 50M/' /usr/local/etc/php/php.ini-production
sed -i 's/upload_max_filesize = .*/upload_max_filesize = 50M/' /usr/local/etc/php/php.ini-development  
sed -i 's/post_max_size = .*/post_max_size = 50M/' /usr/local/etc/php/php.ini-development

# Copy to active php.ini
cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini 2>/dev/null || true

# Clear Laravel caches to pick up new routes/config after deployment
cd /home/site/wwwroot
php artisan route:clear 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Start Apache/PHP-FPM
/usr/sbin/apache2ctl -D FOREGROUND
