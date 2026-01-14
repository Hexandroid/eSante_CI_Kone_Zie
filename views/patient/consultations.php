<?php
require_once __DIR__ . '/../../controllers/patient.php';

$id_patient = $_SESSION['id_patient'];
$consultations = get_consultations_patient($id_patient);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes consultations</title>
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
            <h2>Mes consultations</h2>
            
            <?php if (count($consultations) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Médecin</th>
                            <th>Spécialité</th>
                            <th>Symptômes</th>
                            <th>Diagnostic</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultations as $consultation): ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i', strtotime($consultation['date_consultation'])); ?></td>
                                <td><?php echo htmlspecialchars($consultation['medecin_prenom'] . ' ' . $consultation['medecin_nom']); ?></td>
                                <td><?php echo htmlspecialchars($consultation['specialite']); ?></td>
                                <td><?php echo htmlspecialchars(substr($consultation['symptomes'], 0, 50)) . (strlen($consultation['symptomes']) > 50 ? '...' : ''); ?></td>
                                <td><?php echo htmlspecialchars(substr($consultation['diagnostic'] ?? 'En cours', 0, 50)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Vous n'avez aucune consultation enregistrée pour le moment.</p>
            <?php endif; ?>
            
            <div class="mt-20">
                <a href="/eSante-CI/public/index.php?page=patient_dashboard" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</body>
</html>