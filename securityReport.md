# STI Projet 2 - Étude des menaces

Authors: Besseau Thibaud & Rashiti Labinot
Date: 2018-19-12

## Introduction

Ce document a pour but de résumer les travaux effectués dans le cadre de la partie 2 du projet, à savoir : 

- Reprendre un site web réalisé dans le projet pour la première partie
- Effectuer une analyse sur le fonctionnement et la sécurité du site web
- Identifier les vulnérabilités et les menaces
- Corriger et documenter ces vulnérabilités

La première partie du projet consistait à réaliser une application web fonctionnelle. Cette deuxième partie consiste donc à la sécuriser.

## Description du système

Afin de réaliser notre application web, nous devions respecter certains points notamment l'utilisation de PHP version 5.3 ainsi que SQLite. Ces contraintes ont pour but de montrer certaines failles de sécurités dans ces versions et donc de les corriger par nos soins. Aucune autre technologie n'est autorisée.

###Partie WEB

Notre site web se trouve dans le répertoire "html" qui contient la page index et plusieurs répertoires dont :

- public pour les fichiers en rapport avec CSS et javascript
- config pour les fichiers en rapport avec la base de données (fonctions manipulant la base de données)
- src pour les fichiers représentant les différentes pages de notre site

Étant donné que toutes nos pages du site web se trouve dans le répertoire src, nous avons donc les descriptions suivantes :

| Nom du fichier   | Description                                                  |
| :--------------- | :----------------------------------------------------------- |
| compose.php      | Formulaire permettant d'envoyer un message                   |
| delete.php       | Fichier permettant de supprimer un message                   |
| delete_user.php  | Fichier permettant de supprimer un utilisateur               |
| lock_unlock.php  | Fichier permettant de suspendre/activer un utilisateur       |
| login.php        | Formulaire permettant de s'authentifier sur le site web      |
| logout.php       | Fichier permettant de se déconnecter du site web             |
| mailbox.php      | Page affichant l'intégralité des messages destinés à l'utilisateur |
| password.php     | Formulaire permettant de changer le mot de passe utilisateur |
| profile_user.php | Page affichant le profil de l'utilisateur et ses informations |
| read.php         | Page affichant le message reçu pour l'utilisateur            |
| send.php         | Fichier permettant l'envoi du message de l'utilisateur       |
| users.php        | Page affichant la liste des utilisateurs pour l'administrateur |

###Partie Base de données



## Sources de menaces



## Scénarios d'attaques



## Contre-mesures



## Conclusion