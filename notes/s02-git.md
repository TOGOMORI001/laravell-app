# Session 02 - Git et GitHub

Réponses rédigées avec mes propres mots.

## 1. Index et commit

`git add` place les changements choisis dans l'index. `git commit` enregistre le contenu de l'index dans l'historique local. `git push` envoie ensuite les commits vers le dépôt distant.

## 2. Branche et tag

Une branche est un pointeur qui avance quand de nouveaux commits y sont ajoutés. Un tag reste attaché à un commit précis ; `lab-01` marque la fin de la session 01.

## 3. Le fichier `.env`

Le fichier `.env` contient la configuration propre à la machine, dont la clé d'application et des valeurs sensibles. Il ne doit pas être poussé. Un autre développeur copie `.env.example` vers `.env`, puis lance `php artisan key:generate` pour créer sa propre clé.

## 4. Le dossier `vendor/`

`vendor/` contient les dépendances PHP téléchargées par Composer. Il est volumineux et n'est pas versionné ; `composer.lock` permet à `composer install` de réinstaller les versions prévues.

## 5. Git Credential Manager

Git Credential Manager conserve le jeton GitHub dans le gestionnaire d'identifiants sécurisé de Windows pour authentifier les prochains push. Sur un ordinateur personnel, on le garde ; sur un poste partagé de l'université, on le supprime en quittant afin que l'utilisateur suivant ne puisse pas pousser sur le compte.
