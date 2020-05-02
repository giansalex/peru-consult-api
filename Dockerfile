FROM php:7.4-alpine AS build-env

LABEL owner="Giancarlos Salas"
LABEL maintainer="giansalex@gmail.com"

WORKDIR /app

RUN apk update && apk add --no-cache \
    openssl \
    git \
    unzip && \
    curl --silent --show-error -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install --no-interaction --no-dev --optimize-autoloader --ignore-platform-reqs && \
    composer dump-autoload --optimize --no-dev --classmap-authoritative && \

FROM php:7.4-alpine

ENV API_TOKEN abcxyz
EXPOSE 8080
WORKDIR /var/www

RUN apk update && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache && \
    docker-php-ext-install pcntl

# Copy configuration
COPY docker/config/opcache.ini $PHP_INI_DIR/conf.d/
COPY docker/docker-entrypoint.sh .

COPY --from=build-env /app .

ENTRYPOINT ['./docker-entrypoint.sh']