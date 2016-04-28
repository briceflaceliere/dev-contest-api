DevContest - Dev
========================

https://trello.com/b/ryMwROFV/devcontest


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
- Création de la bdd de test : `dca-cmd app/phing reset`


2) Utilisation
----------------------------------

    - Url de l'api : `http://localhost:8039/app_dev.php/api`
    - Doc :  `http://localhost:8039/app_dev.php/api/doc`
    - Mailhog : 'http://localhost:8035/'
    - Executer une commande symfony : `dca-cmd app/console cmdSymfony`
    - Insertion des fixtures : `dca-cmd app/console doctrine:fixtures:load`
    - Reset database : `dca-cmd app/phing reset`
    - Fix automatique des erreur de style: `dca-cmd bin/phing fix`
    - Executer les tests: `dca-cmd bin/phing test`

3) Dependances
----------------------------------

Développer sous php7

L'api utilisent plusieurs dependances :

- Doc de l'api : NelmioApiDocBundle (https://github.com/nelmio/NelmioApiDocBundle)
- Pagination : KnpPaginatorBundle (https://github.com/KnpLabs/KnpPaginatorBundle)
- Serialisation des entity : JMSSerializerBundle (http://jmsyst.com/bundles/JMSSerializerBundle)
- Api Rest : FOSRestBundle (https://github.com/FriendsOfSymfony/FOSRestBundle)
- Api hypermedia : BazingaHateoasBundle (https://github.com/willdurand/BazingaHateoasBundle)
- Test Api : PHPUnit et LiipFunctionalTestBundle (https://github.com/liip/LiipFunctionalTestBundle)