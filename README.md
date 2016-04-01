DevContest - Dev
========================


1) Installation
----------------------------------

- Clone le depot : `git clone git@bitbucket.org:devcontest/dev-contest-api.git`
- Ajout des alias docker :
    
    `alias devcontest="docker exec -u 1000:1000 -it devcontestapi_web_1"`
    `alias devcontest-psql="PGPASSWORD=devcontest psql -h 127.0.0.1 -p 5467 -U devcontest devcontest"`

- Ajout dans `/etc/hosts` : `127.0.0.1 devcontest.perso.dev`
- Lancer les container docker : `cd ./project-dir && docker-compose up`
- Installation des dependances php : `devcontest composer install`
- Création du schema : `devcontest php app/console doctrine:schema:create`


2) Utilisation
----------------------------------

Url de l'api par defaut : `http://devcontest.perso.dev:8039/app_dev.php/api`

Doc de l'api :  `http://devcontest.perso.dev:8039/app_dev.php/api/doc`

Executé un commande symfony : `devcontest cmdSymfony`

3) Dependances
----------------------------------

Api utilisent plusieurs dependances :

- Doc de l'api : NelmioApiDocBundle (https://github.com/nelmio/NelmioApiDocBundle)
- Pagination : KnpPaginatorBundle (https://github.com/KnpLabs/KnpPaginatorBundle)
- Serialisation des entity : JMSSerializerBundle (http://jmsyst.com/bundles/JMSSerializerBundle)
- Api Rest : FOSRestBundle (https://github.com/FriendsOfSymfony/FOSRestBundle)
- Api hypermedia : BazingaHateoasBundle (https://github.com/willdurand/BazingaHateoasBundle)