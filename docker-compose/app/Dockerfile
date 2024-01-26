# FROM php:7.4-fpm
FROM php:8.2-fpm

# Argumentos definidos no docker-compose.yml
ARG user
ARG uid

# Instalando dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    zlib1g-dev \
    libmcrypt-dev \
    libpng-dev \
    libzip-dev \
    libsodium-dev


# Limpando cache do APT
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalando extensões PHP
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring xml exif pcntl bcmath gd zip sodium

# Download da ultima versão do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuario no sistema para executar o Composer e comandos Artisan  
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Declarando permissão 777 no diretório public e storage
# RUN chmod -R 777 /var/www/puclic && chmod -R 777 /var/www/storage

# Declarando diretório de trabalho
WORKDIR /var/www

USER $user

