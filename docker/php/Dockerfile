FROM php:8.0.2-fpm

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
        wget \
        zbar-tools \
        zlib1g-dev && \
    pecl install imagick decimal apcu xdebug-3.0.3 &&  \
    docker-php-ext-enable imagick decimal apcu && \
    useradd -ms /bin/bash php-fpm && \
    rm -rf /var/lib/{apt,dpkg,cache,log}/

COPY --from=composer:2.1.9 /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ && \
    docker-php-ext-install \
        bcmath \
        gd \
        intl \
        opcache \
        pdo_mysql \
        soap \
        sockets \
        zip \
        xml

EXPOSE 9000
