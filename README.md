[![Maintainability](https://api.codeclimate.com/v1/badges/0c3dc0ad0ebf601580f4/maintainability)](https://codeclimate.com/github/Kzhiti/Projet6/maintainability)

# Projet6

Création d'un site communautaire de partage de figures de snowboard via le framework Symfony.

Environnement utilisé durant le développement

Symfony 5.2.6

Bootstrap 5.0.x

WampServer 3.2.3

PHP 7.4.9

MySQL 5.7.31

Installation
Clonez ou téléchargez le repository GitHub dans le dossier voulu :

    git clone https://github.com/sorha/P6-SnowTricks.git

Renseignez la base de données dans le fichier .env dans la section MySQL.

Téléchargez et installez les dépendances back-end du projet avec Composer :

    composer install

Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :

    php bin/console doctrine:database:create
Créez les différentes tables de la base de données en appliquant les migrations :

    php bin/console doctrine:migrations:migrate
    
Ajouter un .htaccess dans public/

    <IfModule mod_rewrite.c>
           RewriteEngine On
           RewriteCond %{REQUEST_FILENAME} !-f
           RewriteCond %{REQUEST_FILENAME} !-d
           RewriteRule ^(.*)$ index.php [QSA,L]
    </IfModule>
    
Le projet est maintenant installé correctement, vous pouvez désormais commencer à l'utiliser.