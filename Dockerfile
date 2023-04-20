FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    default-mysql-client

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

# Create the database
RUN mysql -h 127.0.0.1 -u root -proot -e "CREATE DATABASE IF NOT EXISTS notebook_api"

# Copy the .env.example file to .env
RUN cp .env.example .env

# Generate the application key
RUN php artisan key:generate

# Install the dependencies
RUN composer install --no-dev --prefer-dist --no-scripts --no-progress --no-interaction

# Run the database migrations and seed the database
RUN php artisan migrate:fresh --seed --force

CMD ["php-fpm"]

EXPOSE 9000
