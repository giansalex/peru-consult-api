FROM php:7.1-apache

LABEL owner="Giancarlos Salas"
LABEL maintainer="giansalex@gmail.com"

RUN apt-get update && \
    apt-get install -y --no-install-recommends git && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    curl --silent --show-error -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV API_TOKEN abcxyz
ENV docker "true"

# Copy configuration
COPY docker/config/opcache.ini $PHP_INI_DIR/conf.d/
RUN a2enmod rewrite

COPY . /var/www/html/

VOLUME /var/www/html/logs

RUN cd /var/www/html && \
    chmod -R 777 ./logs && \
    cp -f docker/.htaccess . && \
    cp -f docker/settings.php src/ && \
    composer install --no-interaction --no-dev --optimize-autoloader && \
    composer dump-autoload --optimize --no-dev --classmap-authoritative