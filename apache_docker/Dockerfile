FROM httpd:2.4-alpine

RUN apk update; apk upgrade;

# copie de notre configuration du virtual host pour les requêtes Php
COPY apache-vhost.conf /usr/local/apache2/conf/apache-vhost.conf

RUN echo "Include /usr/local/apache2/conf/apache-vhost.conf" \
    >> /usr/local/apache2/conf/httpd.conf