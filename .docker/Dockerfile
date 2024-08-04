ARG CI=false


#################
# Backend Setup #
#################
FROM composer:2.2 as phpsetup

WORKDIR /app

COPY . /app/

# Install backend dependencies
RUN if [[ $CI != *"true"* ]]; \
        then composer install --ignore-platform-reqs --optimize-autoloader --no-interaction; \
        else composer install --ignore-platform-reqs --optimize-autoloader --no-interaction --no-dev; \
    fi

RUN composer dump-autoload


##################
# Frontend Setup #
##################
FROM node:lts-alpine3.18 as nodesetup

WORKDIR /app

# Install frontend dependencies
COPY package*.json /app
RUN npm install --omit optional

COPY resources /app/resources
COPY public /app/public
COPY vite.config.js tailwind.config.js /app/
COPY --from=phpsetup /app/vendor /app/vendor

# Build Frontend
RUN npm run build


###########
# Runtime #
###########
FROM dunglas/frankenphp:php8.3-alpine

WORKDIR /app

# Runtime requirements
RUN apk add --update --no-cache ffmpeg
# fix: imagick/imagick@master - https://github.com/Imagick/imagick/issues/643#issuecomment-2086949716
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
    pdo_pgsql \
    imagick/imagick@master

# Copy Application
COPY . /app

RUN touch /app/.env

RUN mkdir /docker-init
COPY ./.docker/init/* /docker-init/

COPY ./.docker/entrypoint /usr/local/bin

COPY --from=nodesetup /app/public/build /app/public/build
COPY --from=phpsetup /app/vendor /app/vendor

ENTRYPOINT [ "entrypoint" ]
