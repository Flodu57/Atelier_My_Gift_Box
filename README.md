# Atelier 1 : My Gift Box

Groupe LP2 : CORDIER Florian, RALLI Alexandre, ROHRBACHER Léon, ZINK Anthony

Vous pouvez également consulter l'application en ligne sur [https://webetu.iutnc.univ-lorraine.fr/www/zink2u/mygiftbox/home](https://webetu.iutnc.univ-lorraine.fr/www/zink2u/mygiftbox/home).

Pour le déploiement sur Webetu, l'envoi de mail et les fonctionnalités qui en dépendent sont désactivées puisque le proxy de l'IUT nous en empêche.

# Consignes d'installation

## Mise en place du serveur

* Clonez le repository et configurez Apache de façon à avoir accès à ce dossier
* Placez vous à la racine du repository et lancez `composer install` ([https://getcomposer.org/](https://getcomposer.org/))

## Configuration de MySql

* Lancez MySql sur votre machine ([https://www.mysql.com/fr/](https://www.mysql.com/fr/))
* Créez une nouvelle base de données 'mygiftbox'
* Modifiez le fichier 'src/conf/config.ini' et remplacez les champs 'host', 'username' et 'password' en fonction de votre configuration
* Executez le script de création des tables 'assets/sql/giftbox.sql'

## Compilation sass

En utilisant sass ([https://sass-lang.com/](https://sass-lang.com/)), compilez les fichiers .scss en fichiers .css en éxécutant la commande suivante :
```
sass assets/scss/style.scss assets/css/style.css
```
