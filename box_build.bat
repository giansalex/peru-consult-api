@echo off 
COPY docker\settings.php src\settings.php
MOVE public\assets assets
DEL public\.htaccess
RMDIR /s /q vendor
composer install --no-dev --optimize-autoloader
box build