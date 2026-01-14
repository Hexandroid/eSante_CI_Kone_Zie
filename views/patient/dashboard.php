<?php
require_once __DIR__ . '/../../controllers/patient.php';

$id_patient = $_SESSION['id_patient'];
$dossier = get_dossier_patient($id_patient);
$consultations = get_consultations_patient($id_patient);
$ordonnances = get_ordonnances_patient($id_patient);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Patient</title>
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
        <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?></h2>
        
        <div class="grid">
            <div class="grid-item">
                <h3>Mon dossier médical</h3>
                <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($dossier['date_naissance'] ?? 'Non renseignée'); ?></p>
                <p><strong>Groupe sanguin :</strong> <?php echo htmlspecialchars($dossier['groupe_sanguin'] ?? 'Non renseigné'); ?></p>
                <a href="/eSante-CI/public/index.php?page=patient_dossier" class="btn">Voir mon dossier</a>
            </div>
            
            <div class="grid-item">
                <h3>Mes consultations</h3>
                <p><strong>Nombre total :</strong> <?php echo count($consultations); ?></p>
                <?php if (count($consultations) > 0): ?>
                    <p><strong>Dernière consultation :</strong> <?php echo date('d/m/Y', strtotime($consultations[0]['date_consultation'])); ?></p>
                <?php else: ?>
                    <p>Aucune consultation enregistrée</p>
                <?php endif; ?>
                <a href="/eSante-CI/public/index.php?page=patient_consultations" class="btn">Voir mes consultations</a>
            </div>
            
            <div class="grid-item">
                <h3>Mes ordonnances</h3>
                <p><strong>Nombre total :</strong> <?php echo count($ordonnances); ?></p>
                <?php if (count($ordonnances) > 0): ?>
                    <p><strong>Dernière ordonnance :</strong> <?php echo date('d/m/Y', strtotime($ordonnances[0]['date_ordonnance'])); ?></p>
                <?php else: ?>
                    <p>Aucune ordonnance enregistrée</p>
                <?php endif; ?>
                <a href="/eSante-CI/public/index.php?page=patient_ordonnances" class="btn">Voir mes ordonnances</a>
            </div>
        </div>
    </div>
</body>
</html>