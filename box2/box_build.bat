@echo off
CD ..
COPY docker\settings.php src\settings.php
RMDIR /s /q vendor
composer install --no-dev --optimize-autoloader
box build
MKDIR dist
MOVE consult.phar dist\consult.phar
MOVE public\assets dist\assets
COPY public\.htaccess dist\.htaccess
COPY box2\index.php dist\index.php
git checkout .