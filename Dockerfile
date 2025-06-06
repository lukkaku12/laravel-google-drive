FROM php:8.3-fpm

# Instalar dependencias y extensiones
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    libcurl4-openssl-dev libpq-dev gnupg curl lsb-release \
    apt-transport-https unixodbc unixodbc-dev vim \
    && docker-php-ext-install \
        zip pdo pdo_mysql pdo_pgsql mbstring exif gd bcmath \
    && apt-get clean \
    && sed -i "s|listen = 127.0.0.1:9000|listen = 0.0.0.0:9000|g" /usr/local/etc/php-fpm.d/www.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www

# ⚠️ Copiamos TODO el proyecto primero, así incluye el archivo 'artisan'
COPY . .

# Copiar archivo .env si no existe
RUN cp .env.example .env || true

# ⚠️ Luego instalamos dependencias
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Permisos
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]