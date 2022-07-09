FROM php:8.1-fpm-alpine
#RUN usermod -u 1000 www-data
RUN apk add shadow && usermod -u 1000 www-data && groupmod -g 1000 www-data

ADD ./src /var/www/html

WORKDIR /var/www/html

#RUN sudo chmod o+w ./storage/ -R
RUN chown -R 1000:1000 /var/www/
RUN chown -R www-data:www-data /var/www/*
RUN chmod -R 777 /var/www/html/*
RUN chmod -R 777 /var/www/html/storage
RUN chmod -R ugo+rw /var/www/html/storage
#RUN usermod -u 1000 www-data
RUN docker-php-ext-install pdo pdo_mysql
