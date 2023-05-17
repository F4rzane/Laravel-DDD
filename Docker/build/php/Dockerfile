FROM php:8.2-fpm-alpine3.16

ENV RUN_DEPS="bash freetype git icu-libs icu libgd libintl libjpeg-turbo libpng libwebp libxml2 libxpm libzip openssh-client patch postgresql-libs su-exec zlib" \
    BUILD_DEPS="${PHPIZE_DEPS} autoconf g++ make   pcre-dev icu-dev openssl-dev freetype-dev icu-dev libjpeg-turbo-dev libpng-dev libwebp-dev libxml2-dev libxpm-dev libzip-dev  postgresql-dev zlib-dev" \
    PECL_EXTS="apcu xdebug" \
    PHP_EXTS="gd intl pgsql pcntl pdo_pgsql soap zip"
ENV PHP_JPEG_DIR="/usr" \
    PHP_PNG_DIR="/usr" \
    PHP_ZLIB_DIR="/usr" \
    PHP_WEBP_DIR="/usr" \
    PHP_INI_SCAN_DIR="/usr/local/etc/php/conf.d/:/usr/local/etc/php/conf-override.d/" \
    # fixes iconv
    LD_PRELOAD="/usr/lib/preloadable_libiconv.so"

RUN apk --no-cache add shadow

RUN    apk update \
    && apk upgrade \
    && apk add --no-cache $RUN_DEPS \
    && apk add -t .build-deps $BUILD_DEPS \
    && docker-php-ext-configure gd \
              --with-freetype \
              --with-jpeg \
              --enable-gd-jis-conv \
    && docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) $PHP_EXTS \
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache \
    && pecl channel-update pecl.php.net \
    && pecl install -o -f $PECL_EXTS \
    && docker-php-ext-enable $PECL_EXTS \
    && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && pecl clear-cache \
    && apk del .build-deps \
    # Clear
    && rm -rf /tmp/* /var/cache/apk/*

ARG uid
ARG gid

RUN echo "assigning www-data the ${uid} and ${gid}" \
    && usermod -u 1000 www-data \
    && groupmod -g 1000 www-data

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer




RUN echo 'max_execution_time = 120' >> /usr/local/etc/php/conf.d/docker-php-maxexectime.ini;


RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
