
FROM php:8.0-apache

COPY . /var/www/html/

EXPOSE 8000

RUN sed -i 's/Listen 80/Listen 8000/' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8000/' /etc/apache2/sites-available/000-default.conf

CMD ["apache2-foreground"]


