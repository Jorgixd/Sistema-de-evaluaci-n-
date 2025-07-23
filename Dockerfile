
# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala extensiones necesarias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Habilita el módulo de reescritura de Apache
RUN a2enmod rewrite

# Copia el contenido del proyecto al contenedor
COPY . /var/www/html/

# Establece los permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto 80 para acceso web
EXPOSE 80
