FROM php:8.2-apache

# Activer mod_rewrite
RUN a2enmod rewrite

# Changer la racine Apache vers /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Mettre à jour la config Apache
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Copier le projet
COPY . /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html
