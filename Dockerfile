FROM php:7.1-alpine AS build-env

LABEL owner="Giancarlos Salas"
LABEL maintainer="giansalex@gmail.com"

WORKDIR /app

RUN apk update && apk add --no-cache \
    openssl \
    git \
    unzip && \
    curl --silent --show-error -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN cp -f docker/.htaccess . && \
    cp -f docker/settings.php src/ && \
    rm -rf docker

RUN composer install --no-interaction --no-dev --optimize-autoloader --ignore-platform-reqs && \
    composer dump-autoload --optimize --no-dev --classmap-authoritative && \
    find vendor/ -type f  ! -name "*.php"  -delete

FROM php:7.1-apache

ENV API_TOKEN abcxyz
ENV docker "true"

RUN apt-get update && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Copy configuration
COPY docker/config/opcache.ini $PHP_INI_DIR/conf.d/
RUN a2enmod rewrite

COPY --from=build-env /app /var/www/html

VOLUME /var/www/html/logs