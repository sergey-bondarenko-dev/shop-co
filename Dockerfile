FROM wordpress:6-php8.3-apache

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY docker/php/conf.d/shop-co-performance.ini /usr/local/etc/php/conf.d/shop-co-performance.ini

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        default-mysql-client \
        git \
        less \
        unzip \
        zip; \
    curl -fsSL -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar; \
    chmod +x /usr/local/bin/wp; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
