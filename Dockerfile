FROM php:8.2-apache

# Installer les dépendances système nécessaires à MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Activer mod_rewrite
RUN a2enmod rewrite

# Définir public/ comme racine du site
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Mettre à jour la config Apache
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Copier le projet
COPY . /var/www/html

# Droits
RUN chown -R www-data:www-data /var/www/html
