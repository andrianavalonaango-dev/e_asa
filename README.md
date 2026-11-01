# E-ASA

E-ASA est une application web de recherche d'emploi. Les candidats peuvent consulter les offres et postuler; les recruteurs peuvent gérer leur entreprise, publier des offres et suivre les candidatures.

## Technologies

- **PHP 8.2+** et **Laravel 12** pour le serveur, les routes, l'authentification et l'accès aux données.
- **Blade** pour les vues de l'application.
- **SQLite** comme base de données par défaut. La configuration Laravel prend aussi en charge MySQL, MariaDB et PostgreSQL.
- **Tailwind CSS 4** pour les styles.
- **Vite 7** pour compiler et servir les ressources CSS et JavaScript.
- **Composer** pour les dépendances PHP et **npm** pour les dépendances front-end.
- **PHPUnit 11** pour les tests.

## Prérequis

- PHP 8.2 ou version ultérieure, avec l'extension PDO SQLite activée.
- Composer.
- Node.js et npm.

## Installation et lancement (Windows / PowerShell)

Depuis la racine du projet, créez le fichier SQLite s'il n'existe pas encore, puis lancez le script d'installation Composer. Celui-ci installe les dépendances, crée le fichier `.env` si nécessaire, génère la clé de l'application, exécute les migrations et compile les ressources front-end.

```powershell
if (-not (Test-Path database/database.sqlite)) {
    New-Item -ItemType File database/database.sqlite | Out-Null
}
composer run setup
```

Pour lancer l'application en mode développement avec le serveur Laravel, Vite et les services de queue et de logs, exécutez :

```powershell
composer run dev
```

Ouvrez ensuite l'adresse affichée par Laravel, généralement <http://127.0.0.1:8000>. Laissez ce terminal ouvert pendant le développement.

## Lancement séparé

Vous pouvez aussi démarrer Laravel et Vite dans deux terminaux distincts :

```powershell
php artisan serve
```

```powershell
npm run dev
```

## Tests

```powershell
composer run test
```

Pour compiler les ressources front-end pour la production :

```powershell
npm run build
```