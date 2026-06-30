FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan untuk koneksi MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Aktifkan mod_rewrite (opsional, berguna jika ada URL rewriting)
RUN a2enmod rewrite

# Set working directory ke document root Apache
WORKDIR /var/www/html

# Copy seluruh source code project ke dalam image
COPY . /var/www/html/

# Pastikan permission folder upload gambar (assets) bisa ditulis Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80