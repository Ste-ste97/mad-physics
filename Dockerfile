FROM php:8.3-fpm

ARG uid
ARG gid

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl \
    mariadb-client \
    libwebp-dev \
    libicu-dev \
    supervisor \
    cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* && \
    apt-get update

# Install extensions for php
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl intl && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get clean && apt-get autoremove -y

RUN echo "* * * * * root cd /var/www && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/scheduler && \
    chmod 0644 /etc/cron.d/scheduler && \
    crontab /etc/cron.d/scheduler && \
    service cron start;

Run if [ "$uid" != "0" ] ; then \
       usermod -u $uid www-data && \
       groupmod -g $gid www-data; \
    fi


WORKDIR /var/www