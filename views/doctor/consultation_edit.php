<?php
require_once __DIR__ . '/../../controllers/doctor.php';
require_once __DIR__ . '/../../controllers/consultation.php';
require_once __DIR__ . '/../../controllers/prescription.php';

$error = '';
$success = '';
$id_medecin = $_SESSION['id_medecin'];
$id_consultation = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_consultation === 0) {
    header('Location: /eSante-CI/public/index.php?page=doctor_consultations');
    exit();
}

$consultation = get_consultation_medecin($id_consultation, $id_medecin);

if (!$consultation) {
    header('Location: /eSante-CI/public/index.php?page=doctor_consultations');
    exit();
}

$ordonnance = get_ordonnance_by_consultation($id_consultation);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $symptomes = trim($_POST['symptomes']);
    $diagnostic = trim($_POST['diagnostic']);
    $traitement = trim($_POST['traitement']);
    
    if (empty($symptomes)) {
        $error = 'Les symptômes sont obligatoires.';
    } else {
        $result = update_consultation($id_consultation, $id_medecin, $symptomes, $diagnostic, $traitement);
        
        if ($result['success']) {
            $success = $result['message'];
            $consultation = get_consultation_medecin($id_consultation, $id_medecin);
        } else {
            $error = $result['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la consultation</title>
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
            <h2>Modifier la consultation</h2>
            <p><strong>Patient :</strong> <?php echo htmlspecialchars($consultation['patient_prenom'] . ' ' . $consultation['patient_nom']); ?></p>
            <p><strong>Date :</strong> <?php echo date('d/m/Y H:i', strtotime($consultation['date_consultation'])); ?></p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="symptomes">Symptômes *</label>
                    <textarea id="symptomes" name="symptomes" required><?php echo htmlspecialchars($consultation['symptomes']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="diagnostic">Diagnostic</label>
                    <textarea id="diagnostic" name="diagnostic"><?php echo htmlspecialchars($consultation['diagnostic'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="traitement">Traitement</label>
                    <textarea id="traitement" name="traitement"><?php echo htmlspecialchars($consultation['traitement'] ?? ''); ?></textarea>
                </div>
                
                <button type="submit" class="btn">Enregistrer les modifications</button>
                <?php if (!$ordonnance): ?>
                    <a href="/eSante-CI/public/index.php?page=doctor_ordonnance_create&consultation_id=<?php echo $id_consultation; ?>" class="btn btn-success">Créer une ordonnance</a>
                <?php endif; ?>
                <a href="/eSante-CI/public/index.php?page=doctor_consultations" class="btn btn-secondary">Retour</a>
            </form>
            
            <?php if ($ordonnance): ?>
                <div class="card mt-20">
                    <h3>Ordonnance associée</h3>
                    <p><strong>Date :</strong> <?php echo date('d/m/Y', strtotime($ordonnance['date_ordonnance'])); ?></p>
                    <p><strong>Médicaments :</strong></p>
                    <p><?php echo nl2br(htmlspecialchars($ordonnance['medicaments'])); ?></p>
                    <p><strong>Posologie :</strong></p>
                    <p><?php echo nl2br(htmlspecialchars($ordonnance['posologie'])); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>