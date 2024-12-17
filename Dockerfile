FROM php:8.1-apache
RUN docker-php-ext-install mysqli
COPY ./src/ /var/www/html/

# Копируем наш конфиг Apache
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Включаем mod_rewrite
RUN a2enmod rewrite

# Перезапускаем Apache
CMD ["apache2-foreground"]

