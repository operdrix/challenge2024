# Projet Challenge Stack M1-IW Semestre 1 2024

![PHP Version](https://img.shields.io/badge/php->=8.2-4f5b93.svg?style=for-the-badge)
![Symfony Version](https://img.shields.io/badge/symfony-6.4.4-000.svg?style=for-the-badge)
[![Flowbite Version](https://img.shields.io/badge/flowbite->=2.3-1c64f2.svg?style=for-the-badge)](https://flowbite.com)
[![License](https://img.shields.io/github/license/talesfromadev/flowbite-bundle?style=for-the-badge)](https://github.com/tales-from-a-dev/flowbite-bundle/blob/main/LICENSE)

> Un projet réalisé par Kenza Schuler, Loan Courchinoux-Billonnet, Arnaud Gouel, Quentin Somveille, Mathis Rome et Olivier Perdrix

## Le sujet

[Lien vers le Notion](https://haudrey.notion.site/Projet-M1-Portail-formation-c747aa56e1ba466083fa1c03614f96f0)

Vous allez créer un outil de gestion pour client formateur freelance permettant de gérer efficacement les formations, les étudiants, les cours en ligne, les examens et les démos techniques. Avec une interface conviviale, des fonctionnalités de communication et de suivi des progrès, il offre une solution complète pour optimiser l'activité de formateur freelance.

## Installation du projet en local

### Via l'utilitaire Make

1. clôner le repository

```bash
mkdir eduMentor
cd eduMentor
git clone https://github.com/operdrix/challenge2024.git .
```

2. Exécuter l'utilitaire [Make](<[Make](https://ioflood.com/blog/install-make-command-linux/#:~:text=In%20most%20Linux%20distributions%2C%20the,command%20sudo%20yum%20install%20make%20.)>)

```bash
make build
```

### Via Docker Compose

1. clôner le repository

```bash
mkdir eduMentor
cd eduMentor
git clone https://github.com/operdrix/challenge2024.git .
```

2. Exécuter le conteneur docker

```bash
docker compose up -d
docker exec php /bin/bash
```

3. Récupérer les dépendances

```bash
composer install
npm install
npm run dev
```

4. Configurer les variables locales

Créer un fichier .env.local dans le dossier app

```bash
# /app/.env.local
DATABASE_URL="mysql://root:root@mariadb:3306/app"

```

5. Créer la base de donnée

```bash
# Dans le shell du container
php bin/console d:d:c
php bin/console d:m:m
php bin/console d:f:l
```

## Accéder à l'application

-   Application : http://localhost
-   PhpMyAdmin : http://localhost:8080

## Technologies

-   Symfony
    -   Bundle Webapp
    -   TailwindCss & Flowbite
    -   Bundle KnpPaginator
    -   Webpack Encore
    -   ...
-   MariaDb
-   Docker
