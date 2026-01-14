<?php
require_once __DIR__ . '/../../controllers/patient.php';

$id_patient = $_SESSION['id_patient'];
$dossier = get_dossier_patient($id_patient);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon dossier médical</title>
    <link rel="stylesheet" href="/eSante-CI/public/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>eSanté-CI - Espace Patient</h1>
        </div>
    </header>

    <nav>
        <div class="container">
            <ul>
                <li><a href="/eSante-CI/public/index.php?page=patient_dashboard">Tableau de bord</a></li>
                <li><a href="/eSante-CI/public/index.php?page=patient_dossier">Mon dossier</a></li>
                <li><a href="/eSante-CI/public/index.php?page=patient_consultations">Mes consultations</a></li>
                <li><a href="/eSante-CI/public/index.php?page=patient_ordonnances">Mes ordonnances</a></li>
                <li><a href="/eSante-CI/public/index.php?page=logout">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Mon dossier médical</h2>
            
            <div class="info-row">
                <span class="info-label">Nom complet :</span>
                <span class="info-value"><?php echo htmlspecialchars($dossier['prenom'] . ' ' . $dossier['nom']); ?></span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Email :</span>
                <span class="info-value"><?php echo htmlspecialchars($dossier['email']); ?></span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Date de naissance :</span>
                <span class="info-value"><?php echo $dossier['date_naissance'] ? date('d/m/Y', strtotime($dossier['date_naissance'])) : 'Non renseignée'; ?></span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Sexe :</span>
                <span class="info-value"><?php echo $dossier['sexe'] === 'M' ? 'Masculin' : 'Féminin'; ?></span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Groupe sanguin :</span>
                <span class="info-value"><?php echo htmlspecialchars($dossier['groupe_sanguin'] ?? 'Non renseigné'); ?></span>
            </div>
            
            <h3 class="mt-20">Allergies</h3>
            <p><?php echo $dossier['allergies'] ? nl2br(htmlspecialchars($dossier['allergies'])) : 'Aucune allergie connue'; ?></p>
            
            <h3 class="mt-20">Antécédents médicaux</h3>
            <p><?php echo $dossier['antecedents'] ? nl2br(htmlspecialchars($dossier['antecedents'])) : 'Aucun antécédent médical enregistré'; ?></p>
            
            <div class="mt-20">
                <a href="/eSante-CI/public/index.php?page=patient_dashboard" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</body>
</html>