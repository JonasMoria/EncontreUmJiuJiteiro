FROM php:8.3-fpm-bookworm

ARG APP_UID=1000
ARG APP_GID=1000

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        intl \
        opcache \
        pdo_mysql \
        pcntl \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN groupadd --gid "${APP_GID}" app \
    && useradd --uid "${APP_UID}" --gid "${APP_GID}" --create-home --shell /bin/bash app

COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-app.ini

# PHP-FPM roda como usuário não-root via Compose. O PID fica em /tmp.
RUN sed -i 's|^;pid =.*|pid = /tmp/php-fpm.pid|' /usr/local/etc/php-fpm.conf

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm", "-F"]
