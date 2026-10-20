# #####################PHP

FROM php:8.4-fpm-alpine AS php-target
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

# Copy composer files first
COPY . .

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# RUN composer install --optimize-autoloader --no-interaction

COPY ./deploy/php/entrypoint.sh /bin/entrypoint.sh
RUN chmod +x /bin/entrypoint.sh

# Copy package files for frontend
# RUN npm ci

# Copy rest of the app
COPY --chown=www-data:www-data . /var/www/html/

# Build frontend assets
# RUN npm run build

# Run the application
EXPOSE 9000
EXPOSE 5173
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
CMD ["php-fpm"]
# CMD ["npm", "run", "dev", "--", "--host"]
ENTRYPOINT ["/bin/entrypoint.sh"]
