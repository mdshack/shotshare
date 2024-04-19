FROM dunglas/frankenphp:latest-php8.3.6-alpine

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

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:start", "--server", "frankenphp", "--host=0.0.0.0", "--port=80", "--admin-port=2019"]
