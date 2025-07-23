
FROM php:8.2-apache

# Habilitar módulo rewrite
RUN a2enmod rewrite

# Copiar todo el proyecto al contenedor
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Asignar permisos apropiados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
