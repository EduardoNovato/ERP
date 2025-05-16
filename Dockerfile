# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Habilitar mod_rewrite para permitir URLs limpias (necesario para el router)
RUN a2enmod rewrite

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Copiar configuración personalizada de Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
