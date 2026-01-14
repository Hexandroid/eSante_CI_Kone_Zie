<?php
require_once __DIR__ . '/../../controllers/doctor.php';

$patients = get_all_patients();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des patients</title>
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
            <h2>Liste des patients</h2>
            
            <?php if (count($patients) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de naissance</th>
                            <th>Sexe</th>
                            <th>Groupe sanguin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($patient['nom']); ?></td>
                                <td><?php echo htmlspecialchars($patient['prenom']); ?></td>
                                <td><?php echo $patient['date_naissance'] ? date('d/m/Y', strtotime($patient['date_naissance'])) : '-'; ?></td>
                                <td><?php echo $patient['sexe'] === 'M' ? 'M' : 'F'; ?></td>
                                <td><?php echo htmlspecialchars($patient['groupe_sanguin'] ?? '-'); ?></td>
                                <td>
                                    <a href="/eSante-CI/public/index.php?page=doctor_patient_edit&id=<?php echo $patient['id_patient']; ?>" class="btn">Modifier</a>
                                    <a href="/eSante-CI/public/index.php?page=doctor_consultation_create&patient_id=<?php echo $patient['id_patient']; ?>" class="btn btn-success">Nouvelle consultation</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun patient enregistré dans le système.</p>
            <?php endif; ?>
            
            <div class="mt-20">
                <a href="/eSante-CI/public/index.php?page=doctor_dashboard" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</body>
</html>