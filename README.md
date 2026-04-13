C'est une application Symfony avec API Platform. À savoir qu'en haut du sujet, il est précisé que nous pouvons utiliser du PHP, j'ai donc choisi Symfony. J'ai trouvé que cette technologie était appropriée car elle facilite la création d'endpoints et la mise en place du CRUD, tout en permettant de générer facilement des fixtures pour les tests.

Url github: https://github.com/cdwfs26-012/api
URL de la doc : http://127.0.0.1:8000/api/docs
LES TESTs: 

SCREENSHOTs : 
dans le public/images/tests
avec aussi un json extrait de mon postman

si besoin le sql est a la racine du projet
Pour load les dataFixture
php bin/console doctrine:fixtures:load

Pour se login
/api/auth

Body :
{
    "email": "admin@legendre.fr",
    "password": "test"
}

Consulter la tournée d'un chauffeur
/api/tours?driver=/api/drivers/{uuid_du_chauffeur}
/api/tours?driver=/api/drivers/0x019d86b8dd8574edafc7c38967113e6c

Voir la liste des tournée d'un chauffeur
{{base_url}}/api/tours?driver=0x019d86b8dd8574edafc7c38967113e6c
Consulter les livraisons d’une tournée
/api/deliveries?tour={uuid_de_la_tournee}
/api/deliveries?tour=0x019d86b8dec470558af3b5e8ae2b7961

PATCH pour modifier le status d'une livraison
/api/deliveries/019d86b8-dec5-7eba-a036-40463fb89575?
Dans postman
body :
{
"status": "DELIVERED"
}

Header
Content-Type application/merge-patch+json


Consulté les infos d'un client
/api/clients/{uuid_du_client}
/api/clients/019d86b8-debf-72bf-b2e2-15d0bbf1b0cc

Consulter les marchandises
/api/products


Les droits
- ROLE_ADMIN : Accès total à l'ensemble du système (gestion des chauffeurs, des stocks/marchandises et supervision des tournées).
- ROLE_CHAUFFEUR : Accès restreint à la consultation des tournées et à la mise à jour des livraisons (changement de statut via PATCH)
- ROLE_CLIENT : Accès limité à la consultation de ses propres informations de livraison pour le suivi.
- PUBLIC_ACCESS : Seuls les endpoints d'authentification et la documentation Swagger sont accessibles sans jeton.




