
# UrbanNest

## Prérequis

- [Symfony CLI](https://symfony.com/download)
- [PHP 8.1](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/download/)
- [SASS](https://sass-lang.com/)
- Un compilateur SASS

  /!\ Les prérequis peuvent évoluer au fil du projet en fonction des besoins, assurez-vous de les vérifier régulièrement. /!\

  ### Vérification des prérequis

  #### Symfony

  ```
  symfony -v
  ```

  #### PHP

  ```
  php -v
  ```
  Doit être égal ou supérieur à PHP 8.1

  #### Composer

  ```
  composer -v
  ```

  #### Git

  ```
  git -v
  ```

  #### Un compilateur SASS
  A verifier selon votre IDE

## Utilisation de CodeSpace (Recommandé)

Créer un compte sur CodeSpace (de préférence avec le compte github @it-students.fr)
Sélectionner le repos ``urban-nest``
Sélectionner la branch ``develop``
Localisation : Europe West
Machine Type : 2-core -32GB (ROM) - 8GB (RAM) (Amplement Suffisant pour le projet actuel)

[Documentation complète](https://github.com/cogendar38/urban-nest/wiki/Utilisation-de-Codespace)

## Installation du projet

Il est recommandé d'utiliser SSH pour cloner le projet (vous devez au préalable [configurer une clé SSH](https://docs.github.com/en/authentication/connecting-to-github-with-ssh/adding-a-new-ssh-key-to-your-github-account)), cependant, selon l'emplacement où vous vous trouvez (Campus Région du Numérique), cela peut ne pas fonctionner, généralement en raison d'un blocage de ports, par exemple sur le CRN. Dans ce cas, utilisez HTTPS.

### SSH

  ```
  git clone git@github.com:cogendar38/urban-nest.git
  ```

### Https
```
git clone https://github.com/cogendar38/urban-nest.git
```

## Installation des dépendances

Une fois le projet cloné sur votre ordinateur, vous devrez installer les dépendances, notamment Composer.

### Composer
```
composer install
```
Cette commande installera toutes les dépendances nécessaires au projet contenues dans le fichier `package.json`. Attention, au fur et à mesure du projet, les dépendances évolueront, il faudra donc effectuer cette commande à chaque fois dans la branche `develop` après avoir effectué un `git pull` et avant de passer sur une nouvelle branche.

## Configuration

Pour fonctionner, l'application se base sur un fichier `.env`, celui-ci va permettre de stocker toutes les variables d'environnement (de configuration). Celui-ci étant poussé sur le repo, il est **INTERDIT** de stocker des mots de passe dans le fichier `.env`, notamment les credentials SMTP ou de base de données. Ceux-ci devront être stockés dans le fichier `.env.dev` pendant la phase de développement et dans le `.env.prod` lors de la mise en production. Le fichier `.env.dev` n'étant pas poussé sur le repo Git, il sera donc nécessaire de le créer et de le mettre à jour **manuellement** en se basant sur la documentation technique (Google Doc pour le moment).

### Base de données

Toutes les données de l'application (comptes utilisateur, offres immobilières, etc.) sont stockées dans une base de données en mode développement, sur votre PC. Il sera nécessaire de faire la commande `php bin/console doctrine:migrations:migrate` régulièrement, donc après avoir fait un pull et avant de passer sur une nouvelle branche.

Afin d'éviter de devoir créer de fausses annonces immobilières chacun de son côté, des données de test seront fournies appelées sur Symfony des `Fixtures`. Pour charger les fixtures dans la base de données, vous devrez exécuter la commande suivante :

```
php bin/console doctrine:fixtures:load
```
Après avoir chargé les migrations bien entendu. À chaque modification de la structure des tables, merci de m'avertir afin que je mette à jour mes fixtures. En cas de modifications des fixtures, une notification sur Discord sera faite, toutefois, pensez à vérifier s'il y a des modifications après avoir effectué un `git pull`.

## Lancement de l'application

Après avoir correctement configuré et vérifié les [prérequis](#Prérequis), vous pouvez désormais lancer l'application. Soit via votre serveur (consultez la documentation de votre serveur), soit via Symfony en exécutant la commande suivante dans le dossier racine du projet (le dossier qui contient le `.git`):

```
symfony server:start
```
Votre application sera alors disponible sur [https://localhost:8000](https://localhost:8000)

/!\**ATTENTION**/!\ Si vous choisissez d'héberger via un serveur de dev tels que Xampp, Wampp, etc., le dossier à configurer dans le vhost sera `/public` et non pas le dossier racine (avec le .git)

## Gestion de projet
### Création des branches
Pour travailler de manière structurée et collaborative, nous utilisons des branches git pour chaque nouvelle fonctionnalité ou correctif. Voici comment créer une nouvelle branche :

```
git checkout develop          # Assurez-vous d'être sur la branche 'develop'
git pull origin develop       # Mettez à jour votre branche 'develop' locale avec les dernières modifications
git checkout -b nom_de_la_nouvelle_branche    # Créez une nouvelle branche depuis 'develop' pour une nouvelle fonctionnalité ou un correctif
```

### Nommage des branches
Afin de maintenir un suivi clair et organisé du projet, nous utilisons une convention de nommage des branches :

## Introduction

Les numéros de carte sont des identifiants uniques associés aux tâches dans notre tableau Kanban. Cette documentation vise à expliquer comment utiliser ces numéros pour une meilleure traçabilité des tâches dans le Kanban et leur association aux branches Git correspondantes.

## Utilisation des Numéros de Carte

Chaque carte dans notre tableau Kanban est numérotée pour faciliter son suivi. Voici comment les numéros de carte sont utilisés :

- Chaque carte dans la colonne "À faire" ou "En cours" est identifiée par un numéro (ex: F1, F2, B1, R1, etc.).
- Les lettres correspondent à différentes catégories : 
  - `F` pour les fonctionnalités en cours de développement.
  - `B` pour les correctifs de bugs.
  - `R` pour les refactorisations.
  - Et d'autres lettres pour d'autres catégories si nécessaires.
- Ce numéro est affiché en haut à gauche de chaque carte dans le tableau Kanban.
- Le nom de la feature est également affiché dans la carte pour une identification plus claire et rapide.

## Association avec les Branches Git

Chaque numéro de carte est directement lié à une branche Git pour suivre l'avancement du développement. Voici comment associer les numéros de carte aux branches Git :

- Lorsque vous créez une nouvelle fonctionnalité, branchez-vous à partir de `develop` et nommez la branche en utilisant le numéro de carte suivi du nom de la fonctionnalité.
  Exemple : `git checkout -b F1-feature-name`
- Veillez à utiliser le même numéro de carte dans le nom de la branche Git pour maintenir la traçabilité.

### Nommage des branches

Lorsque vous travaillez sur une fonctionnalité, pensez à vous attribuer la carte correspondante dans le tableau Kanban. Assurez-vous d'utiliser la convention de nommage des branches pour maintenir la clarté et l'organisation du projet.

### Règles du Flux de Travail

Il est essentiel de respecter certaines règles pour maintenir l'intégrité du dépôt Git :

1. **Interdiction de Push sur la branche `main`:** Il est strictement interdit de pousser directement du code sur la branche `main`. Tous les changements doivent être intégrés via des Pull Requests.

2. **Travailler dans des branches distinctes :** Chaque tâche doit être réalisée dans une branche distincte, issue de `develop`.

3. **Gestion des Bugs :** En cas de bug, ne revenez pas directement sur votre branche de travail. Créez une Issue décrivant le bug rencontré, puis créez une nouvelle branche pour corriger ce bug en utilisant le numéro de carte suivi d'un identifiant de correction.
  Exemple : `B10-feature-name`

- Le nommage s'effectue de cette façon :
  - `B` : Signifie qu'il s'agit d'un Bug.
  - `1` : Correspond au numéro de la fonctionnalité initiale.
  - `0` : Un identifiant unique qui commence à partir de 0 et qui s'incrémente, 0 lors du premier bug de cette fonctionnalité, 1 lors d'un autre bug, etc.

Ces règles contribuent à maintenir un flux de travail ordonné et à garantir la qualité du code intégré dans le dépôt Git.
