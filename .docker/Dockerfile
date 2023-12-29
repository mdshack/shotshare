FROM mdshack/php:8.3-fpm-alpine-caddy

ENV XDG_CONFIG_HOME /config
ENV XDG_DATA_HOME /data

EXPOSE 80
EXPOSE 443

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install Node/NPM
RUN apk add --update --no-cache nodejs npm

WORKDIR /app

RUN install-php-extensions \
    dom \
    fileinfo \
    session \
    simplexml \
    tokenizer \
    xml \
    xmlwriter \
    pcntl \
    pdo_mysql


# Install frontend dependencies
COPY package*.json /app
RUN npm install --omit optional

# Copy Application
COPY --chown=www-data . /app

RUN composer install --no-interaction --no-dev --optimize-autoloader

# Build Frontend
RUN npm run build

# Cleanup
RUN rm -rf /app/node_modules /usr/local/bin/composer /usr/local/bin/npm /usr/local/bin/node /usr/local/lib/node_modules

COPY --chown=www-data ./.docker/Caddyfile /etc/caddy/Caddyfile
COPY --chown=www-data ./.docker/init/* /docker-init/

RUN touch /app/.env
RUN chown www-data:www-data /app/.env
