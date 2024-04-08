# test-recrutement-laravel

Mini backoffice to test applicants tech level with Laravel

# Pré-requis:
* 
* Editeur : exp: PHPSTORM
* PHP
* Composer

# Installation:
* 
* Installation PHP
* Installation de Composer
* Configuration de l'environnement .env :

/*
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:DXhZ7khKE26ku5gRjpsCQ4ElhDhTP71BeGfZERpHGA0=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=14432
DB_DATABASE=test1
DB_USERNAME=postgres
DB_PASSWORD=Bakchlamo@@12345

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
*/

* Configurer la base de données : Dans le fichier .env, configurez les détails de connexion de la base de données.
* Migration de la base de données : php artisan migrate
  
# Démarrage:
* Lancement du serveur de développement : php artisan serve

# Fabriqué avec: 
PHP Laravel

# Auteurs: 
- pspascal
- KamariMohammed
- maguetteS
