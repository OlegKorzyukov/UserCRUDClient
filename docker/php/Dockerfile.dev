FROM php:8.0.2-fpm

USER root

RUN apt-get update && \
    apt-get -y --no-install-recommends install \
        git \
        libaio1 \
        libmagickwand-dev \
        libmpdec-dev \
        libssl-dev \
        libzip-dev \
        software-properties-common \
        uchardet \
        unzip \
        wget \
        zbar-tools \
        zlib1g-dev && \
    pecl install imagick decimal apcu xdebug-3.0.3 &&  \
    docker-php-ext-enable imagick decimal apcu && \
    groupadd -g 999 php-fpm && \
    useradd -ms /bin/bash -u 999 -g 999 php-fpm && \
    rm -rf /var/lib/{apt,dpkg,cache,log}/

COPY --from=composer:2.1.9 /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ && \
    docker-php-ext-install -j$(nproc) \
        bcmath \
        gd \
        intl \
        opcache \
        pdo_mysql \
        soap \
        sockets \
        zip \
        xml

ENV COMPOSER_ALLOW_SUPERUSER 1

ARG XDEBUG_REMOTE_HOST
ARG XDEBUG_REMOTE_PORT
RUN docker-php-ext-enable xdebug \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=$XDEBUG_REMOTE_HOST" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=$XDEBUG_REMOTE_PORT" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN touch /var/log/xdebug.log
RUN chmod -R 777 /var/log
RUN usermod --non-unique --uid 1000 www-data \
  && groupmod --non-unique --gid 1000 www-data \
  && chown -R www-data:www-data /var/www

USER www-data

EXPOSE 9000
