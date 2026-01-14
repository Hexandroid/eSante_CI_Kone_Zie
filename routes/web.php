<?php
// Routeur simple pour gérer les pages

// Démarrer la session uniquement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../controllers/auth.php';

// Récupérer la page demandée
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Définir le chemin des vues
$views_path = __DIR__ . '/../views/';

// Routes publiques (accessibles sans connexion)
$public_routes = ['home', 'login', 'register'];

// Vérifier si l'utilisateur doit être connecté
if (!in_array($page, $public_routes) && !est_connecte()) {
    header('Location: /eSante-CI/public/index.php?page=login');
    exit();
}

// Router vers la bonne vue
switch ($page) {
    // Routes publiques
    case 'home':
        include $views_path . 'home.php';
        break;

    case 'login':
        include $views_path . 'auth/login.php';
        break;

    case 'register':
        include $views_path . 'auth/register.php';
        break;

    case 'logout':
        deconnexion();
        break;

    // Routes patient
    case 'patient_dashboard':
        verifier_role('patient');
        include $views_path . 'patient/dashboard.php';
        break;

    case 'patient_dossier':
        verifier_role('patient');
        include $views_path . 'patient/dossier.php';
        break;

    case 'patient_consultations':
        verifier_role('patient');
        include $views_path . 'patient/consultations.php';
        break;

    case 'patient_ordonnances':
        verifier_role('patient');
        include $views_path . 'patient/ordonnances.php';
        break;

    // Routes médecin
    case 'doctor_dashboard':
        verifier_role('medecin');
        include $views_path . 'doctor/dashboard.php';
        break;

    case 'doctor_patients':
        verifier_role('medecin');
        include $views_path . 'doctor/patients.php';
        break;

    case 'doctor_patient_edit':
        verifier_role('medecin');
        include $views_path . 'doctor/patient_edit.php';
        break;

    case 'doctor_consultations':
        verifier_role('medecin');
        include $views_path . 'doctor/consultations.php';
        break;

    case 'doctor_consultation_create':
        verifier_role('medecin');
        include $views_path . 'doctor/consultation_create.php';
        break;

    case 'doctor_consultation_edit':
        verifier_role('medecin');
        include $views_path . 'doctor/consultation_edit.php';
        break;

    case 'doctor_ordonnance_create':
        verifier_role('medecin');
        include $views_path . 'doctor/ordonnance_create.php';
        break;

    default:
        include $views_path . '404.php';
        break;
}
