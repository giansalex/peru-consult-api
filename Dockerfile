FROM php:8.0-alpine3.13 AS build-env

LABEL owner="Giancarlos Salas"
LABEL maintainer="giansalex@gmail.com"

ENV APP_ENV prod
WORKDIR /app

RUN apk update && apk add --no-cache \
    openssl \
    git \
    unzip && \
    curl --silent --show-error -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN git apply docker/drift-kernel.patch
RUN git apply docker/drift-adapter.patch
RUN composer install --no-interaction --no-dev --optimize-autoloader --ignore-platform-reqs && \
    composer require drift/server:0.1.24 --ignore-platform-reqs && \
    composer require react/filesystem:^0.1.2 --ignore-platform-reqs && \
    composer dump-autoload --optimize --no-dev --classmap-authoritative && \
    composer dump-env prod --empty && \
    find -name "[Tt]est*" -type d -exec rm -rf {} + && \
    find -type f -name '*.md' -delete;

FROM php:8.0-alpine3.13

ENV APP_ENV=prod
ENV API_TOKEN=abcxyz
ENV TRUSTED_PROXIES="127.0.0.1,REMOTE_ADDR"
EXPOSE 8080
WORKDIR /var/www/html

RUN apk update && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache && \
    docker-php-ext-install pcntl

COPY --from=build-env /app .

# Copy configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/config $PHP_INI_DIR/conf.d/
COPY docker/docker-entrypoint.sh .

CMD ["sh", "./docker-entrypoint.sh"]
