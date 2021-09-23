FROM php:7.3-apache

RUN \
    docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-configure mysqli --with-mysqli=mysqlnd --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql 

# composerのインストール
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite
