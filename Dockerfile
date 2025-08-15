# Base PHP 8.2 com Alpine
FROM php:8.2-cli-alpine

# Instala dependências do sistema e driver PostgreSQL
RUN apk add --no-cache \
    bash \
    libpq \
    postgresql-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto
COPY . .

# Instala dependências do Laravel
RUN composer install

# Dá permissões de escrita
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expõe a porta 9000
EXPOSE 9000

# Comando padrão: iniciar Laravel na porta 9000
CMD php artisan serve --host=0.0.0.0 --port=9000
