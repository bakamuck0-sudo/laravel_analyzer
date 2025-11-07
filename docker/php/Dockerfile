# Начинаем с официального образа PHP
FROM php:8.2-fpm

# Устанавливаем инструменты и расширения PHP, которые нужны Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nodejs \
    npm

# Включаем расширения PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Устанавливаем Redis
RUN pecl install redis && docker-php-ext-enable redis

# Устанавливаем Composer (менеджер пакетов PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую папку
WORKDIR /var/www

# Копируем весь наш проект внутрь контейнера
COPY . /var/www


# Устанавливаем npm зависимости
RUN npm install

# Устанавливаем права на папки, в которые Laravel пишет логи и кэш
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Выставляем наружу порт, который слушает PHP-FPM
EXPOSE 9000
