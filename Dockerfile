FROM php:8.2-fpm

# Variables para usuario del contenedor
ARG user
ARG uid

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario para desarrollo
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Configura directorio de trabajo
WORKDIR /var/www

# Copia los archivos y cambia permisos
COPY . /var/www
RUN chown -R $uid:$uid /var/www

# Corre comandos como el usuario creado
USER $user