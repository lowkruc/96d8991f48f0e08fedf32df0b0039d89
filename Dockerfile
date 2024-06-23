# Menggunakan image PHP Apache versi 8.2
FROM php:8.2-apache

# Mengaktifkan mod_rewrite untuk URL rewriting
RUN a2enmod rewrite

# Menginstall dependensi yang dibutuhkan
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libpq-dev \
    postgresql-client \
    && docker-php-ext-install zip pdo_pgsql

# Menyalin file proyek PHP ke dalam container
COPY ./ /var/www/html/

# Menentukan working directory
WORKDIR /var/www/html

RUN chmod 777 -R -f /var/www/html/log/consumer/

# Mengexpose port 80 untuk akses HTTP
EXPOSE 80

# Menyalin file konfigurasi Apache
COPY apache.conf /etc/apache2/conf-available/

# Mengaktifkan konfigurasi
RUN a2enconf apache.conf

# Instal Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN composer install --no-scripts --no-autoloader

# Add a script to start the consumer
COPY start-consumer.sh /usr/local/bin/start-consumer.sh
RUN chmod +x /usr/local/bin/start-consumer.sh