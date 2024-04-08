FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip unzip git libpq-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_pgsql zip

# Création du répertoire de travail
WORKDIR /var/www/html

# Copier tout le projet dans le conteneur
COPY . /var/www/html/

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installation des dépendances du projet Laravel
RUN composer install

# Configuration des permissions pour l'utilisateur Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage

# Exposer le port Apache
EXPOSE 80

# Commande par défaut pour démarrer le service PHP-FPM
CMD ["php-fpm"]


