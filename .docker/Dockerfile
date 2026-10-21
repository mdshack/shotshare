FROM php:8.3.36-fpm-alpine

ARG CI=false

ENV XDG_CONFIG_HOME /config
ENV XDG_DATA_HOME /data

EXPOSE 80
EXPOSE 443

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install Node/NPM
RUN apk add --update --no-cache nodejs npm caddy

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions
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
    pdo_mysql \
    pdo_pgsql


# Install frontend dependencies
COPY package*.json /app
RUN npm install --omit optional

COPY .docker/docker-php-entrypoint /usr/local/bin/docker-php-entrypoint

# Copy Application
COPY --chown=www-data . /app

RUN if [[ $CI != *"true"* ]]; \
        then composer install --no-interaction --optimize-autoloader; \
        else composer install --no-interaction --optimize-autoloader --no-dev; \
    fi

# Build Frontend
RUN npm run build

# Cleanup
RUN if [[ $CI != *"true"* ]] ; then rm -rf /app/node_modules /usr/local/bin/composer /usr/local/bin/npm /usr/local/bin/node /usr/local/lib/node_modules ; fi

COPY --chown=www-data ./.docker/Caddyfile /etc/caddy/Caddyfile
COPY --chown=www-data ./.docker/init/* /docker-init/

RUN touch /app/.env
RUN chown www-data:www-data /app/.env

ENTRYPOINT ["/usr/local/bin/docker-php-entrypoint"]
