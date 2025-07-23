FROM php:8.2-apache

# Instala extensiones necesarias para PDO con PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar todo el proyecto al contenedor
COPY . /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Permisos adecuados para Apache
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Configurar Apache para que use index.php por defecto
RUN echo '<IfModule dir_module>\n\
    DirectoryIndex index.php index.html\n\
</IfModule>' > /etc/apache2/mods-enabled/dir.conf

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
