<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bienvenue - Mini-CMS</title>
        <style>
            body {
                max-width: 40rem;
                margin: 3rem auto;
                padding: 0 1rem;
                color: #1f2937;
                font-family: system-ui, sans-serif;
                line-height: 1.6;
            }

            h1 {
                color: #e6291b;
            }
        </style>
    </head>
    <body>
        <h1>Bienvenue, {{ $etudiant }}</h1>
        <p>Groupe : {{ $groupe }}</p>
        <p>Cours : {{ $cours }}</p>
        <p><a href="/">Accueil</a> | <a href="/a-propos">À propos</a> | <a href="/heure">Heure</a></p>
    </body>
</html>
