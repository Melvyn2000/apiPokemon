# apiPokemon (Symfony)

### Installation du projet 🎉

1) Pour installer le projet, veuillez __cloner le dépôt GitHub__ sur votre local.  
Ensuite, effectuez la commande suivante pour installer toutes les dépendances nécessaires au bon fonctionnement du projet : 
```
composer install
```
ment mettre en place la structure de la base de donnée (__BDD__). Pour cela, créez la base de donnée avec la commande suivante : 
```
php bin/console doctrine:database:create
```
* Pensez bien à modifier votre fichier `.env` pour la configuration à votre BDD.  

3) Créez le schéma des entités pour votre BDD : 
```
php bin/console make:migration
```
4) Puis envoyez vos modifications et votre schéma à votre BDD : 
```
php bin/console doctrine:migrations:migrate
```

### Commande personnalisée 🖲️
- `command:add-user` : __Pour créer de nouveaux utilisateurs__
- `command:add-ability` : __Pour importer les données "abilities" des Pokémons__
- `command:add-type` : __Pour importer les données "types" des Pokémons__
- `command:add-pokemon` : __Pour importer les Pokémons__
