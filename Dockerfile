FROM php:8.3-fpm-alpine

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

# Copy Application
COPY --chown=www-data:www-data . /app

# Install Backend Dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install & Build Frontend
RUN npm install --omit optional
RUN npm run build

# Cleanup
RUN rm -rf /app/node_modules

USER www-data

CMD [ "php-fpm" ]
