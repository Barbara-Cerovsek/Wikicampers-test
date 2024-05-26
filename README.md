# Test technique Wikicampers - Application de gestion des disponibilités de véhicules en location sous Symfony

Ce test technique sous Symfony nous a été envoyé par l'entreprise Wikicampers dans le cadre du recrutement des développeurs web en alternance. 

Cette application permet de gèrer les opérations CRUD (la lecture, la création, la modification et la suppression) des disponibilités d'un véhicule, la création d'un nouveau véhicule et l'affichage des résultats de recherche des véhicules disponibles à une certaine période. 

Grace à ce projet, j'ai pu découvrir l'utilisation du framework Symfony, que je ne connaissais pas auparavant. Pour le rendu coté front, j'ai utilisé les templates twig, qui font partie du framework et Bootstrap pour la stylisation. 

Par manque de temps (travail à plein temps en plus de cette nouvelle découverte du sujet), je n'ai pas pu finaliser et debogger cette exercise jusqu'au bout dans le temps prévu. La recherche des disponibilités me retourne toujours un tableau vide, malgré que je ne reçois aucune erreur interne. 

## Installation

L'application peut être testée sur localhost. 

1. Les prérequis : https://symfony.com/doc/current/setup.html
- PHP 8.2 ou plus
- Composer
- Symfony CLI (ou pas, cela dépend de votre préconfiguration de votre environement local)

##  La base de données

Une fois le projet cloné, dans le fichier .env, choisissez le type de votre base de données, décommentez la et renseignez vos identifiants (username, mot de passe, nom de la base de données, la version du serveur web utilisé). Par exemple, si vous utilisez MySQL, vous allez choisir DATABASE_URL correspondante et la modifier pour qu'elle puisse éxecuter la connexion à la BDD - exemple:

`DATABASE_URL="mysql://username:password@127.0.0.1:3306/nomBaseDeDonnees?serverVersion=8.3.7&charset=utf8mb4" `


## Installez les dépendances 

 `composer install`

## Créez la base de données correspondant au projet 

`php bin/console doctrine:database:create`

## Créez les tables dans la base de données

`php bin/console doctrine:migrations:migrate`

## Démarrez le serveur (cela va dépendre de votre configuration)

 `symfony server:start` ou `phhp -S localhost:8000 -t public`# Wikicampers
