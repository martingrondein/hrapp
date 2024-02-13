FROM php:8.2-fpm-alpine

ARG COMPOSER_VERSION="2.7.0"
ARG COMPOSER_SUM="2fc501cbef1891379523ee4989d37bf04798415a05f8eb44ae75acb2fdf2596f"

ARG UID
ARG GID

ENV UID=${UID} GID=${GID}

# System dependencies
RUN set -eux \
    && apk add --no-cache \
    ca-certificates \
    freetype \
    git \
    make \
    musl \
    musl-utils \
    musl-locales \
    tzdata \
    nano \
    nodejs \
    npm \
    openssl \
    tar \
    unzip \
    vim \
    yaml

# System PHP Extensions + configuration
RUN set -eux \
    && apk add --no-cache \
    curl-dev \
    freetype-dev \
    icu-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libsodium-dev \
    libzip-dev \
    openssl-dev \
    yaml-dev \
    zlib-dev

# PHP Extensions + configuration
RUN set -eux \
    && docker-php-ext-install \
    bz2 \
    exif \
    gd \
    intl \
    pcntl \
    pdo_mysql \
    sodium \
    zip \
    && docker-php-ext-configure \
    gd --with-jpeg --with-webp --with-freetype


# Composer
RUN set -eux \
    && curl -LO "https://getcomposer.org/download/${COMPOSER_VERSION}/composer.phar" \
    && echo "${COMPOSER_SUM}  composer.phar" | sha256sum -c - \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer \
    && composer --version \
    && true

# Set working directory
WORKDIR /var/www

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf

# Copy existing application directory contents
COPY --chown=laravel:laravel . /var/www

# Set the user
USER laravel

STOPSIGNAL SIGQUIT

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]