# eSanté-CI - Système de Gestion de Santé

## Description

eSanté-CI est une application web simple de gestion de santé développée en PHP procédural. Elle permet aux patients de consulter leur dossier médical et aux médecins de gérer les consultations et ordonnances.

## Caractéristiques

### Pour les Patients
- Consultation du dossier médical personnel
- Visualisation des consultations passées
- Accès aux ordonnances

### Pour les Médecins
- Gestion des dossiers patients
- Création et modification de consultations
- Création d'ordonnances liées aux consultations

## Prérequis

- XAMPP (Apache + MySQL + PHP)
- Navigateur web moderne
- phpMyAdmin (inclus dans XAMPP)

## Installation

### Étape 1 : Préparer l'environnement

1. Installez XAMPP sur votre ordinateur
2. Démarrez Apache et MySQL depuis le panneau de contrôle XAMPP

### Étape 2 : Créer la base de données

1. Ouvrez phpMyAdmin : `http://localhost/phpmyadmin`
2. Créez une nouvelle base de données nommée `esante`
3. Importez le fichier `esante_schema.sql` ou exécutez le script SQL fourni

### Étape 3 : Installer l'application

1. Copiez le dossier `eSante-CI` dans le répertoire `htdocs` de XAMPP
   - Chemin typique : `C:\xampp\htdocs\eSante-CI`

2. Vérifiez la configuration de la base de données dans `config/database.php` :
   ```php
   $host = 'localhost';
   $dbname = 'esante';
   $username = 'root';
   $password = '';
   ```

### Étape 4 : Accéder à l'application

Ouvrez votre navigateur et accédez à :
```
http://localhost/eSante-CI/public/index.php
```

## Structure du projet

```
eSante-CI/
├── config/
│   └── database.php           # Configuration de la base de données
├── controllers/
│   ├── auth.php               # Authentification
│   ├── patient.php            # Fonctions patient
│   ├── doctor.php             # Fonctions médecin
│   ├── consultation.php       # Gestion des consultations
│   └── prescription.php       # Gestion des ordonnances
├── views/
│   ├── auth/
│   │   ├── login.php          # Page de connexion
│   │   └── register.php       # Page d'inscription
│   ├── patient/
│   │   ├── dashboard.php      # Tableau de bord patient
│   │   ├── dossier.php        # Dossier médical
│   │   ├── consultations.php # Liste des consultations
│   │   └── ordonnances.php    # Liste des ordonnances
│   ├── doctor/
│   │   ├── dashboard.php              # Tableau de bord médecin
│   │   ├── patients.php               # Liste des patients
│   │   ├── patient_edit.php           # Modifier un patient
│   │   ├── consultations.php          # Liste des consultations
│   │   ├── consultation_create.php    # Créer une consultation
│   │   ├── consultation_edit.php      # Modifier une consultation
│   │   └── ordonnance_create.php      # Créer une ordonnance
│   ├── home.php               # Page d'accueil
│   └── 404.php                # Page d'erreur
├── public/
│   ├── css/
│   │   └── style.css          # Styles CSS
│   └── index.php              # Point d'entrée
├── routes/
│   └── web.php                # Routeur
├── esante_schema.sql          # Script SQL
└── README.md                  # Documentation
```

## Utilisation

### Inscription

1. Cliquez sur "S'inscrire" depuis la page d'accueil
2. Choisissez votre rôle (Patient ou Médecin)
3. Remplissez le formulaire d'inscription
4. Les patients doivent renseigner leurs informations médicales
5. Les médecins doivent indiquer leur spécialité

### Connexion

1. Utilisez votre email et mot de passe pour vous connecter
2. Vous serez redirigé vers votre tableau de bord selon votre rôle

### Fonctionnalités Patient

- **Tableau de bord** : Vue d'ensemble de votre dossier
- **Mon dossier** : Informations personnelles et médicales
- **Mes consultations** : Historique des consultations
- **Mes ordonnances** : Liste de toutes les ordonnances

### Fonctionnalités Médecin

- **Tableau de bord** : Vue d'ensemble de l'activité
- **Patients** : Liste et gestion des dossiers patients
- **Consultations** : Créer et modifier des consultations
- **Ordonnances** : Créer des ordonnances pour les consultations

## Base de données

### Tables principales

- **users** : Utilisateurs (patients et médecins)
- **patients** : Informations médicales des patients
- **medecins** : Informations des médecins
- **consultations** : Enregistrement des consultations
- **ordonnances** : Prescriptions médicales

## Sécurité

- Mots de passe hashés avec `password_hash()`
- Sessions PHP pour l'authentification
- Vérification des rôles pour l'accès aux pages
- Protection contre les injections SQL avec PDO

## Technologies utilisées

- **Backend** : PHP 7+ (procédural)
- **Base de données** : MySQL
- **Frontend** : HTML5, CSS3
- **Serveur** : Apache (via XAMPP)

## Limitations connues

- Pas de système de récupération de mot de passe
- Interface simple sans framework CSS
- Pas de validation côté client avancée
- Pas de gestion des fichiers médicaux

## Développement futur possible

- Ajout de la recherche de patients
- Système de rendez-vous
- Impression des ordonnances
- Statistiques et rapports
- Messagerie entre patients et médecins

## Support

Pour toute question ou problème, consultez la documentation PHP ou MySQL selon le cas.

## Licence

Projet éducatif - Utilisation libre