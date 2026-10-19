# #####################PHP

FROM php:8.4-fpm-alpine AS php-fpm
WORKDIR /var/www/html

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


RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN npm ci
RUN npm run build

# RUN chown -R www-data:www-data storage bootstrap/cache \
#     && chmod -R ug+rwX storage bootstrap/cache
#
USER www-data
EXPOSE 9000
CMD ["php-fpm"]







############################33

FROM nginx:alpine AS web
WORKDIR /var/www/html

RUN rm /etc/nginx/conf.d/default.conf # под замену и чтоб наверняка

EXPOSE 8080
CMD ["nginx", "-g", "daemon off;"]
