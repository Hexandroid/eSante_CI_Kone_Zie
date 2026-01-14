<?php
require_once __DIR__ . '/../../controllers/doctor.php';

$id_medecin = $_SESSION['id_medecin'];
$patients = get_all_patients();
$consultations = get_consultations_medecin($id_medecin);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Médecin</title>
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
        <h2>Bienvenue, Dr. <?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?></h2>
        
        <div class="grid">
            <div class="grid-item">
                <h3>Patients</h3>
                <p><strong>Nombre total :</strong> <?php echo count($patients); ?></p>
                <a href="/eSante-CI/public/index.php?page=doctor_patients" class="btn">Voir tous les patients</a>
            </div>
            
            <div class="grid-item">
                <h3>Mes consultations</h3>
                <p><strong>Nombre total :</strong> <?php echo count($consultations); ?></p>
                <?php if (count($consultations) > 0): ?>
                    <p><strong>Dernière consultation :</strong> <?php echo date('d/m/Y', strtotime($consultations[0]['date_consultation'])); ?></p>
                <?php endif; ?>
                <a href="/eSante-CI/public/index.php?page=doctor_consultations" class="btn">Voir mes consultations</a>
            </div>
            
            <div class="grid-item">
                <h3>Actions rapides</h3>
                <a href="/eSante-CI/public/index.php?page=doctor_consultation_create" class="btn btn-success">Nouvelle consultation</a>
            </div>
        </div>
        
        <?php if (count($consultations) > 0): ?>
            <div class="card mt-20">
                <h3>Dernières consultations</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Symptômes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($consultations, 0, 5) as $consultation): ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i', strtotime($consultation['date_consultation'])); ?></td>
                                <td><?php echo htmlspecialchars($consultation['patient_prenom'] . ' ' . $consultation['patient_nom']); ?></td>
                                <td><?php echo htmlspecialchars(substr($consultation['symptomes'], 0, 50)) . '...'; ?></td>
                                <td>
                                    <a href="/eSante-CI/public/index.php?page=doctor_consultation_edit&id=<?php echo $consultation['id_consultation']; ?>" class="btn">Modifier</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>