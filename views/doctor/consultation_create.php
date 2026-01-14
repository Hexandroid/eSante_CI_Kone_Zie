<?php
require_once __DIR__ . '/../../controllers/doctor.php';
require_once __DIR__ . '/../../controllers/consultation.php';

$error = '';
$success = '';
$id_medecin = $_SESSION['id_medecin'];
$patients = get_all_patients();
$selected_patient = isset($_GET['patient_id']) ? intval($_GET['patient_id']) : 0;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_patient = intval($_POST['id_patient']);
    $date_consultation = $_POST['date_consultation'];
    $symptomes = trim($_POST['symptomes']);
    $diagnostic = trim($_POST['diagnostic']);
    $traitement = trim($_POST['traitement']);
    
    if (empty($id_patient) || empty($date_consultation) || empty($symptomes)) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        $result = create_consultation($id_patient, $id_medecin, $date_consultation, $symptomes, $diagnostic, $traitement);
        
        if ($result['success']) {
            $success = $result['message'];
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
    <title>Nouvelle consultation</title>
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
            <h2>Nouvelle consultation</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                    <a href="/eSante-CI/public/index.php?page=doctor_consultations">Voir mes consultations</a>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="id_patient">Patient *</label>
                    <select id="id_patient" name="id_patient" required>
                        <option value="">Sélectionnez un patient...</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo $patient['id_patient']; ?>" <?php echo $selected_patient === $patient['id_patient'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($patient['prenom'] . ' ' . $patient['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date_consultation">Date et heure de consultation *</label>
                    <input type="datetime-local" id="date_consultation" name="date_consultation" required value="<?php echo date('Y-m-d\TH:i'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="symptomes">Symptômes *</label>
                    <textarea id="symptomes" name="symptomes" required placeholder="Décrivez les symptômes présentés par le patient..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="diagnostic">Diagnostic</label>
                    <textarea id="diagnostic" name="diagnostic" placeholder="Diagnostic établi..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="traitement">Traitement</label>
                    <textarea id="traitement" name="traitement" placeholder="Traitement prescrit..."></textarea>
                </div>
                
                <button type="submit" class="btn">Créer la consultation</button>
                <a href="/eSante-CI/public/index.php?page=doctor_consultations" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</body>
</html>