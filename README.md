# Configuration du projet de destinations touristiques

Suivez ces étapes pour configurer et exécuter le projet.

## 1. Prérequis

Assurez-vous d'avoir installé :
- PHP 8.2 ou supérieur
- Composer
- MySQL ou SQLite
- Node.js et npm (pour compiler les assets si nécessaire)

## 2. Installation

1. Clonez le dépôt :
   https://github.com/azalluciano/travel.git


2. Configurez le fichier `.env` pour votre base de données :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trip
DB_USERNAME=root
DB_PASSWORD=
```

3. Installez les dépendances PHP :

```bash
composer install
```

4. Générez la clé d'application :

```bash
php artisan key:generate
```

5. Exécutez les migrations et les seeders :

```bash
php artisan migrate --seed
```

6. Créez un lien symbolique pour le stockage :

```bash
php artisan storage:link
```

## 3. Exécution

Lancez le serveur de développement :

```bash
php artisan serve
```

Accédez à l'application dans votre navigateur : http://localhost:8000


## 4. Commandes disponibles

Exporter les destinations en CSV :

```bash
php artisan destinations:export --filename=[nom-du-fichier.csv]
```

## 6. Tests

Exécutez les tests avec :

```bash
php artisan test
```