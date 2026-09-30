FROM php:8.3-apache

# Install PostgreSQL client libraries dan driver pdo_pgsql
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Salin aplikasi jobsheet10 ke web root Apache
COPY jobsheet10/ /var/www/html/

EXPOSE 80
