<?php
require_once __DIR__ . '/../../controllers/doctor.php';

$error = '';
$success = '';
$id_patient = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_patient === 0) {
    header('Location: /eSante-CI/public/index.php?page=doctor_patients');
    exit();
}

$patient = get_patient_by_id($id_patient);

if (!$patient) {
    header('Location: /eSante-CI/public/index.php?page=doctor_patients');
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'date_naissance' => $_POST['date_naissance'],
        'sexe' => $_POST['sexe'],
        'groupe_sanguin' => $_POST['groupe_sanguin'],
        'allergies' => $_POST['allergies'],
        'antecedents' => $_POST['antecedents']
    ];
    
    $result = update_patient($id_patient, $data);
    
    if ($result['success']) {
        $success = $result['message'];
        $patient = get_patient_by_id($id_patient);
    } else {
        $error = $result['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le dossier patient</title>
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
            <h2>Modifier le dossier de <?php echo htmlspecialchars($patient['prenom'] . ' ' . $patient['nom']); ?></h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($patient['date_naissance']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="sexe">Sexe</label>
                    <select id="sexe" name="sexe" required>
                        <option value="M" <?php echo $patient['sexe'] === 'M' ? 'selected' : ''; ?>>Masculin</option>
                        <option value="F" <?php echo $patient['sexe'] === 'F' ? 'selected' : ''; ?>>Féminin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="groupe_sanguin">Groupe sanguin</label>
                    <input type="text" id="groupe_sanguin" name="groupe_sanguin" value="<?php echo htmlspecialchars($patient['groupe_sanguin'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="allergies">Allergies</label>
                    <textarea id="allergies" name="allergies"><?php echo htmlspecialchars($patient['allergies'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="antecedents">Antécédents médicaux</label>
                    <textarea id="antecedents" name="antecedents"><?php echo htmlspecialchars($patient['antecedents'] ?? ''); ?></textarea>
                </div>
                
                <button type="submit" class="btn">Enregistrer</button>
                <a href="/eSante-CI/public/index.php?page=doctor_patients" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</body>
</html>