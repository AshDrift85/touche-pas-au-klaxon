# Touche pas au klaxon

Application intranet de covoiturage entre les sites d'une entreprise : les employés publient leurs trajets, leurs collègues les consultent et les contactent.

Réalisée en **PHP (MVC)** avec **MySQL**, **Bootstrap + Sass**, le routeur [izniburak/router](https://packagist.org/packages/izniburak/router), **PHPUnit** et **PHPStan**.

## Fonctionnalités

| Profil | Possibilités |
|--------|--------------|
| Visiteur | Liste des trajets à venir qui ont encore des places, triés par départ. Connexion. |
| Employé | Détails d'un trajet (fenêtre modale), création d'un trajet, modification et suppression de **ses** trajets. |
| Administrateur | Liste des utilisateurs, création / modification / suppression des agences, liste des trajets, suppression d'un trajet. |

Après chaque écriture en base, un message est affiché (message flash).

## Prérequis

- PHP 8.1 ou plus (extension `pdo_mysql`)
- [Composer](https://getcomposer.org/)
- MySQL 8 ou MariaDB
- Node.js et npm (pour compiler le Sass)

## Installation

```bash
# 1. Récupérer le projet
git clone https://github.com/AshDrift85/touche-pas-au-klaxon.git
cd touche-pas-au-klaxon

# 2. Installer les dépendances PHP et JavaScript
composer install
npm install

# 3. Compiler le CSS (Bootstrap + palette)
npm run build

# 4. Créer la base et la remplir avec le jeu d'essai
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql

# 5. Configurer l'accès à la base
cp .env.example .env
#    puis ouvrir .env et renseigner DB_USER et DB_PASSWORD

# 6. Lancer le site
php -S localhost:8000 -t public
```

Le site est alors disponible sur **http://localhost:8000**.

> `schema.sql` supprime puis recrée la base `touche_pas_au_klaxon` : ne le relancez pas si vous voulez garder vos données.

## Comptes de démonstration

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | `admin@email.fr` | `Admin1234!` |
| Employé | `alexandre.martin@email.fr` | `User1234!` |

Tous les employés du jeu d'essai ont le mot de passe `User1234!`.

> Le jeu d'essai contient des trajets datés de fin 2026. Si plus aucun trajet n'est à venir, modifiez les dates dans `database/seed.sql` et relancez-le.

## Tests et qualité du code

```bash
composer test   # PHPUnit : tests des fonctions qui écrivent en base
composer stan   # PHPStan : analyse du code
```

Les tests utilisent la base `touche_pas_au_klaxon` définie dans `.env` : chaque test supprime ce qu'il a créé.

## Organisation du projet

```
App/Controller/   les contrôleurs (une méthode par page)
model/            les fonctions qui parlent à la base (PDO)
templates/        les pages HTML
public/           point d'entrée (index.php avec les routes), CSS et JS compilés
scss/             la palette et l'import de Bootstrap
tests/            les tests PHPUnit
database/         schema.sql et seed.sql
docs/             MCD (mcd.png) et MLD (mld.md)
```

## Styles (Bootstrap + Sass)

La palette imposée est déclarée une seule fois dans `scss/_variables.scss`, sur les variables Bootstrap (`$primary`, `$secondary`, `$dark`, `$light`, `$danger`, `$success`). Après un changement, relancer `npm run build`.
