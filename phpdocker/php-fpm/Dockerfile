FROM phpdockerio/php:8.4-fpm
WORKDIR "/application"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \
        supervisor \
        openssh-client \
        php8.4-gd \
        php8.4-mysql \
        php8.4-pgsql \
        php8.4-intl \
        php8.4-gmp \
        php8.4-xdebug \
        php8.4-bcmath \
        php8.4-redis \
        php8.4-imagick \
        php8.4-zip \
        php8.4-curl \
        php8.4-xml \
        php8.4-mbstring; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Установка PostgreSQL клиента (опционально, для psql командной строки)
RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        postgresql-client; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Установка MySQL клиента (опционально, для mysql командной строки)
RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        default-mysql-client; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*