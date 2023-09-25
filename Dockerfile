# Menggunakan image PHP 7.3 sebagai base image
FROM php:8.1-apache

# Install dependensi dan ekstensi PHP yang dibutuhkan untuk CodeIgniter
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip

# Install ekstensi GD dan mysqli
RUN docker-php-ext-install gd mysqli

# Aktifkan mod_rewrite untuk Apache
RUN a2enmod rewrite

# Copy kode CodeIgniter ke dalam container
COPY . /var/www/html/

# Set direktori kerja
WORKDIR /var/www/html/

# Expose port 80
EXPOSE 8090

# Jalankan Apache server
CMD ["apache2-foreground"]
