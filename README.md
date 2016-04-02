DevContest - Dev
========================


1) Installation
----------------------------------

- Clone le depot : `git clone git@bitbucket.org:devcontest/dev-contest-api.git`
- Copier et renommer le fichier docker-compose.yml.dist : `cp docker-compose.yml.dist docker-compose.yml`
- Ajout et modifier les alias docker :
    
    `alias dca="docker-compose -f PATHTODOCKERCOMPOSE.yml"`
    `alias dca-cmd="docker exec -u 1000:1000 -it devcontestapi_engine_1"`
    `alias dca-psql="docker exec -it devcontestapi_postgres_1 psql -h 127.0.0.1 -U devcontest devcontest"`

- Lancer les container docker : `dca up -d`
- Installation des dependances php : `dca-cmd composer install`
- Création du schema : `dca-cmd app/console doctrine:schema:create`


2) Utilisation
----------------------------------

    - Url de l'api : `http://localhost:8039/app_dev.php/api`
    - Doc :  `http://localhost:8039/app_dev.php/api/doc`
    - Mailhog : 'http://localhost:8035/'
    - Executé une commande symfony : `dca-cmd app/console cmdSymfony`
    - Exucute test Phpunit : `dca-cmd bin/phpunit -c app/`

3) Dependances
----------------------------------

Développer sous php7

L'api utilisent plusieurs dependances :

- Doc de l'api : NelmioApiDocBundle (https://github.com/nelmio/NelmioApiDocBundle)
- Pagination : KnpPaginatorBundle (https://github.com/KnpLabs/KnpPaginatorBundle)
- Serialisation des entity : JMSSerializerBundle (http://jmsyst.com/bundles/JMSSerializerBundle)
- Api Rest : FOSRestBundle (https://github.com/FriendsOfSymfony/FOSRestBundle)
- Api hypermedia : BazingaHateoasBundle (https://github.com/willdurand/BazingaHateoasBundle)