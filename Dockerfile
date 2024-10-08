FROM php:8.3.6-apache

# Install dependencies and PHP extensions
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y libzip-dev zip nano && \
    docker-php-ext-install pdo pdo_mysql && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install zip

RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.in

# Install Composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# Set the COMPOSER_ALLOW_SUPERUSER environment variable
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy the code into the container
COPY . /var/www/html/

# Set the working directory to /var/www/html/
WORKDIR /var/www/html/

# Install PHPMailer
RUN composer require phpmailer/phpmailer

# Set Apache document root to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# activer la réécriture d'URL
RUN a2enmod rewrite

# Run composer Install
RUN composer install