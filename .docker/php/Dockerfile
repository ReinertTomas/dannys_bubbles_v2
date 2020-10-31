FROM bitnami/php-fpm:7.4.11

WORKDIR /var/www/html/

# Install composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./ /var/www/html/

EXPOSE 9000

CMD ["php-fpm"]