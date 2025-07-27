# Usamos una imagen base que incluye Nginx y PHP-FPM
FROM phpdockerio/php:8.3-fpm

# Instala dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql gd

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Configura los permisos de escritura para storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copia una configuración de Nginx (necesitas crear este archivo)
COPY ./.docker/nginx.conf /etc/nginx/sites-available/default.conf

# Crea un script de inicio para manejar Nginx y PHP-FPM
COPY ./.docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expone los puertos
EXPOSE 80

# Inicia los servicios con el script de entrada
CMD ["docker-entrypoint.sh"]