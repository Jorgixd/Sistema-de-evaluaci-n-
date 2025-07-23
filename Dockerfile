FROM php:8.2-apache

# Instalar dependencias necesarias para compilar extensiones de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Establecer index.php como página por defecto
RUN echo '<IfModule dir_module>\n\
    DirectoryIndex index.php index.html\n\
</IfModule>' > /etc/apache2/mods-enabled/dir.conf

# Copiar todo el proyecto
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Exponer el puerto por defecto de Apache
EXPOSE 80

# Comando por defecto de Apache
CMD ["apache2-foreground"]
