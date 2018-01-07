@echo off
COPY docker/settings.php src/settings.php
DEL public/.htaccess
DEL /q vendor\*
composer install --no-dev --optimize-autoloader
box build