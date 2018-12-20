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

### Partie WEB

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

### Partie Base de données



### Périmètre de sécurisation

Notre périmètre de sécurisation est donné par le cahier des charges. Elle se limite donc uniquement à l'application web, ce qui comprend donc les différents fichiers et fonctionnalités déployés via Apache ou SQLite.

La sécurité concernant le réseau qui entoure l'application ainsi que la sécurisation des machines physiques et la sécurisation des langages/librairies ne sont pas pris en compte ici.

## Sources de menaces

Nous avons regroupé les sources de menaces en plusieurs catégories :

- Utilisateurs malins
  - Probabilité : Haute 
  - Motivation : Avoir plus de privilèges, lire les messages des autres
  - Cible : Les crédentials des utilisateurs et des administrateurs
- Éventuels concurrents
  - Probabilité : Moyenne
  - Motivation : Rendre l'application inutilisable, copier la structure du site web
  - Cible : Le fonctionnement de l'application
- Hacker, script-kiddies
  - Probabilité : Moyenne
  - Motivation : Gain de reconnaissance, amusement
  - Cible : L'entierté de l'application web
- Cybercriminels
  - Probabilité : Faible
  - Motivation : Récupérer des mots de passe, des emails et utiliser le site web comme redirecteur vers des autres sites malveillants
  - Cible : Données de l'utilisateur
- Organisation étatique
  - Probabilité : Très faible
  - Motivation : Récolter des données pour de l'analyse/espionnage
  - Cible : L'entierté de l'application web

## Scénarios d'attaques

Le but de ce point est de définir plusieurs scénarios d'attaques qui pourraient mettre à mal notre application web.

Chaque scénario comportera une description, un niveau d'importance, une source, une motivation, une cible et un contrôle (contre-mesure).

### Vol de données sensibles 

| Titre               | Description                                                  |
| ------------------- | ------------------------------------------------------------ |
| Scénario            | Un utilisateur curieux aimerait lire les messages entre deux collègues car ils ne s'entendent pas bien |
| Impact              | Haut                                                         |
| Source de la menace | Script Kiddies, Hackers, utilisateurs malins                 |
| Motivation          | Gloire (script kiddies, hacker), argent (cybercriminels), fierté (utilisateurs malins) |
| Cible               | Données utilisateurs (mots de passe, rôles, messages)        |
| Contrôles           | Cacher le contenu de la base de données en vérifiant les entrées des utilisateurs |

#### 1. Injection SQL 

L'injection SQL est une attaque classique et très basique. Il est l'attaque la plus utilisée selon le site de l'OWASP. 

Notre site web est touché par ce genre d'attaque à cause des différences champs textes que l'utilisateur peut remplir.

#### 2. Mots de passe en clair dans la base de données

L'autre point sensible dans les bases de données est le stockage des mots de passe. Si un attaquant trouve un accès à la base de donnée par mégarde alors il aura accès au mot de passe en clair. 

Il est fortement recommandé de chiffrer les mots de passe et les enregitrer chiffrés. Cela permettra de cacher les mots de passe même si la base de données est compromise.

### Contournement d'authentification

| Titre               | Description                                                  |
| ------------------- | ------------------------------------------------------------ |
| Scénario            | Un utilisateur arrogant veut montrer à tous ses collègues de quoi il est capable. Pour prouver que c'est lui le meilleur en informatique, il va se connecter en tant qu'administrateur sans connaître le bon mot de passe |
| Impact              | Haut                                                         |
| Source de la menace | Script Kiddies, Hackers, utilisateurs malins                 |
| Motivation          | Gloire (script kiddies, hacker), argent (cybercriminels), fierté (utilisateurs malins) |
| Cible               | Données utilisateurs (mots de passe, rôles, messages)        |
| Contrôles           | Cacher le contenu de la base de données en vérifiant les entrées des utilisateurs |

#### 1. Mot de passe faible

Le mot de passe doit toujours répondre à un certain critère comme sa complexité sur le nombre de caractères, l'utilisation de majuscule, caractères spéciaux ou chiffres.

Tous les utilisateurs devraient respecter ces critères mais surtout l'administrateur car il est le point sensible de toute l'application. L'administrateur peut tout faire sur le site web, le perdre serait catastrophique.

## Contre-mesures



## Conclusion