FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/publico

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install -j"$(nproc)" intl mbstring opcache pdo_pgsql zip \
    && sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" \
        /etc/apache2/sites-available/*.conf \
        /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Esta capa solo cambia cuando cambian las dependencias.
COPY composer.json ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --prefer-dist

COPY . .

# db.php es una configuración local ignorada por Git. Se genera dentro de la
# imagen a partir de la configuración basada en variables de entorno.
RUN cp config/db-config.php config/db.php \
    && composer dump-autoload --no-dev --optimize --no-scripts \
    && mkdir -p runtime publico/assets publico/recursos \
    && chown -R www-data:www-data runtime publico/assets publico/recursos

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
