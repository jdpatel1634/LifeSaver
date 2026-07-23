FROM node:22 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
COPY tailwind.config.js ./
COPY postcss.config.js ./

RUN npm run build


FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache

RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

EXPOSE 80

CMD sh -c "php artisan migrate --force && apache2-foreground"
