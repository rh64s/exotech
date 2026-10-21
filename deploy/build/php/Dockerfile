FROM php:8.4-fpm-alpine
USER root
WORKDIR /var/www/html

# ARG DEV=false

RUN apk add --no-cache \
    curl \
    unzip \
    zip \
    libzip-dev \
    icu-dev \
    libxml2-dev \
    mysql-client \
    gnu-libiconv \
    npm

RUN docker-php-ext-configure zip \
    && docker-php-ext-install -j"$(nproc)" \
    pdo_mysql \
    zip \
    intl \
    opcache

# фикс для iconv (потому что на alpine)
ENV LD_PRELOAD=/usr/lib/preloadable_libiconv.so

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# RUN composer install --optimize-autoloader --no-interaction

COPY ./deploy/php/entrypoint.sh /bin/entrypoint.sh
RUN chmod +x /bin/entrypoint.sh

COPY --chown=www-data:www-data . /var/www/html/

EXPOSE 9000
CMD ["php-fpm"]
ENTRYPOINT ["/bin/entrypoint.sh"]
