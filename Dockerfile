FROM php:8.2.0-fpm-alpine

WORKDIR /var/www/app

RUN apk update && apk add \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    imagemagick \
    nodejs \
    npm

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions imagick

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql gd
RUN apk update add php-imagick

RUN docker-php-ext-install pdo pdo_mysql \
    && apk --no-cache add nodejs npm

RUN docker-php-ext-install gd
# RUN apt install imagemagick && apt install php-imagick

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN chmod 777 -R /var/www/app
