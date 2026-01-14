<?php
require_once __DIR__ . '/../../controllers/doctor.php';

$id_medecin = $_SESSION['id_medecin'];
$consultations = get_consultations_medecin($id_medecin);
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
            <h1>eSanté-CI - Espace Médecin</h1>
        </div>
    </header>

    <nav>
        <div class="container">
            <ul>
                <li><a href="/eSante-CI/public/index.php?page=doctor_dashboard">Tableau de bord</a></li>
                <li><a href="/eSante-CI/public/index.php?page=doctor_patients">Patients</a></li>
                <li><a href="/eSante-CI/public/index.php?page=doctor_consultations">Consultations</a></li>
                <li><a href="/eSante-CI/public/index.php?page=logout">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Mes consultations</h2>
            
            <div class="mb-20">
                <a href="/eSante-CI/public/index.php?page=doctor_consultation_create" class="btn btn-success">Nouvelle consultation</a>
            </div>
            
            <?php if (count($consultations) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Symptômes</th>
                            <th>Diagnostic</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultations as $consultation): ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i', strtotime($consultation['date_consultation'])); ?></td>
                                <td><?php echo htmlspecialchars($consultation['patient_prenom'] . ' ' . $consultation['patient_nom']); ?></td>
                                <td><?php echo htmlspecialchars(substr($consultation['symptomes'], 0, 50)) . (strlen($consultation['symptomes']) > 50 ? '...' : ''); ?></td>
                                <td><?php echo htmlspecialchars(substr($consultation['diagnostic'] ?? 'En cours', 0, 50)); ?></td>
                                <td>
                                    <a href="/eSante-CI/public/index.php?page=doctor_consultation_edit&id=<?php echo $consultation['id_consultation']; ?>" class="btn">Modifier</a>
                                    <a href="/eSante-CI/public/index.php?page=doctor_ordonnance_create&consultation_id=<?php echo $consultation['id_consultation']; ?>" class="btn btn-success">Ordonnance</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Vous n'avez aucune consultation enregistrée pour le moment.</p>
            <?php endif; ?>
            
            <div class="mt-20">
                <a href="/eSante-CI/public/index.php?page=doctor_dashboard" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</body>
</html>