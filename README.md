# test-recrutement-laravel

Mini backoffice to test applicants tech level with Laravel

# Pré-requis:
* Editeur : exp: PHPSTORM
* PHP
* Composer

# Installation:
* Configuration de l'environnement .env :

Copier le fichier .env.default en .env et ajuster les variables à votre environnement si besoin

* Configurer la base de données : Dans le fichier .env et docker-compose.yml, configurez les détails de connexion de la base de données.
* Migration de la base de données : php artisan migrate
  
# Démarrage:
* docker-compose build
* docker-compose up -d

# Migrations database 
* php artisan migrate --path=/database/migrations/2024_04_09_101925_create_brands_table.php   
* php artisan migrate --path=/database/migrations/2024_04_09_104142_create_modeles_table.php
* php artisan migrate --path=/database/migrations/0001_01_01_000000_create_users_table.php 
* php artisan migrate --path=/database/migrations/2024_04_09_092457_create_cars_table.php 
* php artisan migrate --path=/database/migrations/2024_04_07_001008_create_settings_table.php


A vous de jouer 😊

# Fabriqué avec: 
PHP Laravel

# Auteurs: 
- pspascal
- KamariMohammed
- maguetteS
