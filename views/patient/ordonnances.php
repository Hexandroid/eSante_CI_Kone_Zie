<?php
require_once __DIR__ . '/../../controllers/patient.php';

$id_patient = $_SESSION['id_patient'];
$ordonnances = get_ordonnances_patient($id_patient);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes ordonnances</title>
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
            <h2>Mes ordonnances</h2>
            
            <?php if (count($ordonnances) > 0): ?>
                <?php foreach ($ordonnances as $ordonnance): ?>
                    <div class="card mb-20">
                        <h3>Ordonnance du <?php echo date('d/m/Y', strtotime($ordonnance['date_ordonnance'])); ?></h3>
                        
                        <div class="info-row">
                            <span class="info-label">Médecin :</span>
                            <span class="info-value">Dr. <?php echo htmlspecialchars($ordonnance['medecin_prenom'] . ' ' . $ordonnance['medecin_nom']); ?></span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Date de consultation :</span>
                            <span class="info-value"><?php echo date('d/m/Y', strtotime($ordonnance['date_consultation'])); ?></span>
                        </div>
                        
                        <h4 class="mt-20">Médicaments prescrits :</h4>
                        <p><?php echo nl2br(htmlspecialchars($ordonnance['medicaments'])); ?></p>
                        
                        <h4 class="mt-20">Posologie :</h4>
                        <p><?php echo nl2br(htmlspecialchars($ordonnance['posologie'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Vous n'avez aucune ordonnance enregistrée pour le moment.</p>
            <?php endif; ?>
            
            <div class="mt-20">
                <a href="/eSante-CI/public/index.php?page=patient_dashboard" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</body>
</html>