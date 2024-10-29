# Utiliser une image NGINX avec PHP-FPM
FROM richarvey/nginx-php-fpm:latest

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tous les fichiers dans le répertoire de travail
COPY . .

# Installer les dépendances de Composer
RUN composer install --no-dev --optimize-autoloader

# Mise en cache des routes et de la configuration de Laravel
RUN php artisan config:cache
RUN php artisan route:cache
