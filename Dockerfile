FROM php:8.3-apache

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/*

# Pindah ke port 3000 (port 80 tidak boleh dipakai non-root)
RUN sed -i 's/Listen 80/Listen 3000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:3000>/' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

# Izinkan Apache berjalan tanpa root
RUN mkdir -p /var/run/apache2 /var/lock/apache2 /var/log/apache2 \
    && chmod -R 777 /var/run/apache2 /var/lock/apache2 /var/log/apache2

COPY . /var/www/html/
RUN chmod -R a+rX /var/www/html

EXPOSE 3000