# Resa


Application web de réservation de logements de vacances, inspirée d'Airbnb. Développée en PHP natif avec MySQL (PDO), sans framework.

---

## Stack technique

| Couche | Techno |
|--------|--------|
| Backend | PHP 8+ (PDO) |
| Base de données | MySQL — base `RESA` |
| Frontend | HTML/CSS vanilla |
| Auth | Sessions PHP (`session_start`) |

---

## Structure du projet

```
Resa/
├── index.php                    # Page d'accueil publique
├── login.php                    # Authentification
├── login.css                    # Styles de la page login
├── affichage_hebergement.php    # Fiche détail hébergement (non connecté)
├── reservation.php              # Formulaire de réservation
├── bungalow.webp
├── chalet.webp
├── loft marseille.webp
├── Chalet_cosy.avif
│
├── ADM/                         # Espace administrateur
│   ├── dashboard.php
│   └── logout.php
│
└── VAC/                         # Espace vacancier
    ├── vac.php
    ├── affichage_hebergement.php
    └── logout.php
```

---

## Base de données

Base : `RESA`

| Table | Rôle |
|-------|------|
| `HEBERGEMENT` | Données des logements (nom, surface, tarif, photo…) |
| `TYPE_HEB` | Types de logements (bungalow, chalet…) |
| `compte` | Comptes utilisateurs (`USER`, `MDP`, `TYPECOMPTE`) |
| `semaine` | Semaines disponibles (`DATEDEBSEM`) |
| `resa` | Réservations (lien user ↔ hébergement ↔ semaine) |

### Types de comptes (`TYPECOMPTE`)

| Valeur | Rôle | Redirection après login |
|--------|------|------------------------|
| `ADM` | Administrateur | `ADM/dashboard.php` |
| `VAC` | Vacancier | `VAC/vac.php` |

---

## Flux applicatif

```
index.php (public)
    └──> login.php ──> ADM/dashboard.php  (si ADM)
                   └──> VAC/vac.php       (si VAC)

affichage_hebergement.php?id={n}
    └── connecté  ──> reservation.php?noheb={n}
    └── non connecté ──> login.php
```

---

## Installation locale

### Prérequis

- PHP ≥ 8.0
- MySQL ≥ 5.7
- Serveur local : XAMPP / Laragon / WAMP

### Étapes

```bash
# 1. Cloner le repo dans le dossier web de votre serveur local
git clone <url-du-repo> /chemin/vers/htdocs/Resa

# 2. Importer la base de données
mysql -u root -p < resa.sql

# 3. Vérifier les credentials dans les fichiers PHP
# (host, dbname, user, pass — actuellement root/vide)

# 4. Lancer le serveur et accéder à :
# http://localhost/Resa/index.php
```
## Index

Page d'acceuil:

<img width="1906" height="948" alt="home" src="https://github.com/user-attachments/assets/710364d4-c94b-4576-9018-815fb97c9964" />


Formulaire de connexion
<img width="460" height="467" alt="Capture d&#39;écran 2026-04-30 185602" src="https://github.com/user-attachments/assets/d0e2fc5d-293f-40e5-b607-39d7c6e380d6" />



---

## Auteur

Projet réalisé dans le cadre du BTS SIO — option SLAM.
