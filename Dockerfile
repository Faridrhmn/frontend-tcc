# Gunakan image resmi PHP sebagai base image
FROM php:apache

# Salin konten dari direktori saat ini ke /var/www/html di dalam kontainer
COPY . /var/www/html/

# Setel izin untuk direktori dan file
RUN chmod -R 755 /var/www/html

# Buat file konfigurasi Apache yang baru
RUN echo '<Directory "/var/www/html">\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride None\n\
    Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/custom-directory.conf

# Aktifkan konfigurasi Apache yang baru
RUN a2enconf custom-directory

# Mengubah port Apache untuk mendengarkan pada port yang ditentukan oleh variabel lingkungan PORT
RUN sed -i 's/80/${PORT}/' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Ekspos port yang ditentukan oleh variabel lingkungan PORT
EXPOSE ${PORT}

# Jalankan Apache di foreground
CMD ["apache2-foreground"]
