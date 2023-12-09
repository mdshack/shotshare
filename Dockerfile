FROM php:8.3-fpm-alpine

ARG USER="www-data"
ARG UID="82"

RUN id -u ${USER} &>/dev/null || $(adduser --no-create-home --disabled-password --uid ${UID} ${USER})

WORKDIR /app

# Install Prerequisites
RUN apk update && apk upgrade
RUN apk add --update \
    # System Dependencies
    curl \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    oniguruma-dev \
    shadow \
    unzip \
    zip \
    # PHP Extensions
    php-dom \
    php-fileinfo \
    php-session \
    php-simplexml \
    php-tokenizer \
    php-xml \
    php-xmlwriter \
    # Utilities
    composer \
    nodejs \
    npm

RUN docker-php-ext-install pdo_mysql

# Copy Application
COPY --chown=www-data:www-data . /app

# Install Backend Dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install & Build Frontend
RUN npm install --omit optional
RUN npm run build

# Cleanup
RUN rm -rf /app/node_modules

USER ${USER}

EXPOSE 9000

CMD [ "php-fpm" ]
