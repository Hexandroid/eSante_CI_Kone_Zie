<?php
require_once __DIR__ . '/../helpers/auth.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - eSanté-CI</title>
    <link rel="stylesheet" href="/eSante-CI/public/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>eSanté-CI</h1>
        </div>
    </header>

    <div class="container">
        <div class="hero">
            <h2>Bienvenue sur eSanté-CI</h2>
            <p>Votre plateforme de gestion de santé en ligne</p>
            
            <?php if (est_connecte()): ?>
                <p>Bonjour <?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?> !</p>
                
                <?php if ($_SESSION['role'] === 'patient'): ?>
                    <a href="/eSante-CI/public/index.php?page=patient_dashboard" class="btn">Accéder à mon tableau de bord</a>
                <?php else: ?>
                    <a href="/eSante-CI/public/index.php?page=doctor_dashboard" class="btn">Accéder à mon tableau de bord</a>
                <?php endif; ?>
                
                <a href="/eSante-CI/public/index.php?page=logout" class="btn btn-secondary">Se déconnecter</a>
            <?php else: ?>
                <a href="/eSante-CI/public/index.php?page=login" class="btn">Se connecter</a>
                <a href="/eSante-CI/public/index.php?page=register" class="btn btn-success">S'inscrire</a>
            <?php endif; ?>
        </div>

        <div class="grid">
            <div class="grid-item">
                <h3>Pour les Patients</h3>
                <p>Consultez votre dossier médical, vos consultations et ordonnances en ligne.</p>
            </div>
            
            <div class="grid-item">
                <h3>Pour les Médecins</h3>
                <p>Gérez les dossiers de vos patients, créez des consultations et des ordonnances.</p>
            </div>
            
            <div class="grid-item">
                <h3>Sécurisé</h3>
                <p>Vos données de santé sont protégées et sécurisées.</p>
            </div>
        </div>
    </div>
</body>
</html>
