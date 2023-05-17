FROM php:8.2-fpm-buster as php-build
#FROM php:8.2-fpm-buster as php-build

RUN php -v
# ----------[END]----------


# -------------------------
# Install App Requirements
# -------------------------
RUN apt-get clean && \
    apt-get update -y && \
    pecl channel-update pecl.php.net && \
    apt-get install -y \
        apt-utils \
        openssl \
        libzip-dev \
        zip \
        unzip \
        git \
        zlib1g-dev \
        libicu-dev \
        g++ \
        libxml2-dev \
        supervisor && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl && \
    docker-php-ext-install bcmath && \
    # docker-php-ext-install sockets && \
    docker-php-ext-configure soap && \
    docker-php-ext-install soap && \
    docker-php-ext-configure pcntl --enable-pcntl && \
    docker-php-ext-install pcntl

## Install PHP gd library
RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg-dev \
        libjpeg62-turbo-dev \
        libpng-dev && \
    docker-php-ext-configure gd \
        --enable-gd \
        --with-freetype \
        --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd && \
    php -i | grep -i gd

ARG uid
ARG gid

RUN echo "assigning www-data the ${uid} and ${gid}" \
    && usermod -u 1000 www-data \
    && groupmod -g 1000 www-data

COPY --from=composer:2.2.21 /usr/bin/composer /usr/bin/composer
