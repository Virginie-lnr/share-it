# Slim Starter
Preconfigured Slim app including **PHP-DI**, **Twig** and **Doctrine DBAL**.

# Installation
Clone the repository, move into the created directory and install **Composer** dependencies:
```sh
git clone https://github.com/AymDev/Slim-Starter.git slim-app
cd slim-app
composer install
```

# Usage
The web server implementation is left to the developer. 
For a quick start, use the *PHP built-in server* which can also be started with the custom **Composer** command:
```sh
composer serve ou php -S localhost:8000 -t public
```
You will find the default page on `http://localhost:8000`.

# Configuration
Some services are already configured in the `config/bootstrap.php`.
To configure your **Doctrine DBAL** database connection, add your params in `config/doctrine.php`.

# Controllers
A `AbstractController` class is present with methods for rendering **Twig** templates and to redirect to another route.

# Templating
A `link()` function has been added to **Twig** to create links to routes in templates.

## Projet 
Le site **Share It** doit permettre de partager des fichiers (clone de wetransfer)

Sur la page d'accueil, on doit avoir un formulaire qui permet d'envoyer un fichier via 1 formulaire.
Lorsque le formulaire est envoyé, on vérifie que le fichier ait été correctement chargé sur les servers puis on l'enregistre 
dans un dossier `files` avec un nom unique de fichier (datage + chaine de caractère aléatoire).

Enregistrer les informations du fichier en base de données: 
- `ìd` la clé primaire
- `filename`le nom unique du fichier sur le server 
- `original_filename` le nom original du fichier 

Sur une autre page, on doit pouvoir télécharger un fichier 
L'adresse pourrait être `/download/42` (où 42 représente l'identifiant en base de données).

Le lien de téléchargement doi apparaître après avoir envoyé un fichier.