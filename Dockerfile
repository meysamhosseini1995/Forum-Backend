FROM php:8.1-fpm-alpine
#RUN usermod -u 1000 www-data

ADD ./src /var/www/html

WORKDIR /var/www/html

RUN chown -R www-data /var/www/*
RUN chmod 755 /var/www/html
RUN chmod 755 /var/www/html/storage
#RUN usermod -u 1000 www-data
RUN docker-php-ext-install pdo pdo_mysql
