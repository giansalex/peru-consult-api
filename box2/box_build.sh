#!/usr/bin/env bash
cd ..
rm -rf dist
cp box2/settings.php src/settings.php
rm -rf vendor
composer install --no-dev --optimize-autoloader
box build
mkdir dist
mv consult.phar dist/consult.phar
mv public/favicon.ico dist/favicon.ico
cp public/.htaccess dist/.htaccess
cp box2/index.php dist/index.php
git checkout .