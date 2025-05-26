FROM php:8.2-fpm-alpine

# Instalar dependencias necesarias
RUN apk add --no-cache \
        libpq \
        libpq-dev \
        && docker-php-ext-install pdo_pgsql pgsql

# Copiar archivos de la aplicación
COPY . /var/www/html

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html
