FROM php:8.1-fpm

WORKDIR /var/www/

RUN apt-get update && \
    apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install --no-dev --prefer-dist --no-scripts --no-progress --no-interaction

RUN php artisan migrate --force
RUN php artisan db:seed

CMD ["php-fpm"]

EXPOSE 9000
