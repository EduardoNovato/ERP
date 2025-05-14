# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Habilitar mod_rewrite de Apache (útil si usas URLs limpias)
RUN a2enmod rewrite

# Instalar extensiones necesarias (PDO MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# Copiar los archivos del proyecto al contenedor
COPY ./public /var/www/html
COPY ./app /var/www/app
COPY .env /var/www/.env

# Establecer permisos (opcional, pero recomendado)
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www
