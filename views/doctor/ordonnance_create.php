<?php
require_once __DIR__ . '/../../controllers/doctor.php';
require_once __DIR__ . '/../../controllers/prescription.php';

$error = '';
$success = '';
$id_medecin = $_SESSION['id_medecin'];
$id_consultation = isset($_GET['consultation_id']) ? intval($_GET['consultation_id']) : 0;

if ($id_consultation === 0) {
    header('Location: /eSante-CI/public/index.php?page=doctor_consultations');
    exit();
}

$consultation = get_consultation_medecin($id_consultation, $id_medecin);

if (!$consultation) {
    header('Location: /eSante-CI/public/index.php?page=doctor_consultations');
    exit();
}

// Vérifier si une ordonnance existe déjà
$ordonnance_existante = get_ordonnance_by_consultation($id_consultation);
if ($ordonnance_existante) {
    $error = 'Une ordonnance existe déjà pour cette consultation.';
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$ordonnance_existante) {
    $date_ordonnance = $_POST['date_ordonnance'];
    $medicaments = trim($_POST['medicaments']);
    $posologie = trim($_POST['posologie']);
    
    if (empty($date_ordonnance) || empty($medicaments) || empty($posologie)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        $result = create_ordonnance($id_consultation, $date_ordonnance, $medicaments, $posologie);
        
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
    <title>Créer une ordonnance</title>
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
            <h2>Créer une ordonnance</h2>
            
            <div class="card mb-20">
                <h3>Informations de la consultation</h3>
                <p><strong>Patient :</strong> <?php echo htmlspecialchars($consultation['patient_prenom'] . ' ' . $consultation['patient_nom']); ?></p>
                <p><strong>Date de consultation :</strong> <?php echo date('d/m/Y H:i', strtotime($consultation['date_consultation'])); ?></p>
                <p><strong>Diagnostic :</strong> <?php echo htmlspecialchars($consultation['diagnostic'] ?? 'Non renseigné'); ?></p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                    <a href="/eSante-CI/public/index.php?page=doctor_consultation_edit&id=<?php echo $id_consultation; ?>">Retour à la consultation</a>
                </div>
            <?php endif; ?>
            
            <?php if (!$ordonnance_existante): ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="date_ordonnance">Date de l'ordonnance *</label>
                        <input type="date" id="date_ordonnance" name="date_ordonnance" required value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="medicaments">Médicaments prescrits *</label>
                        <textarea id="medicaments" name="medicaments" required placeholder="Liste des médicaments prescrits...
Exemple :
- Paracétamol 1000mg
- Amoxicilline 500mg"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="posologie">Posologie *</label>
                        <textarea id="posologie" name="posologie" required placeholder="Instructions de prise...
Exemple :
- Paracétamol : 1 comprimé 3 fois par jour pendant 5 jours
- Amoxicilline : 1 gélule matin et soir pendant 7 jours"></textarea>
                    </div>
                    
                    <button type="submit" class="btn">Créer l'ordonnance</button>
                    <a href="/eSante-CI/public/index.php?page=doctor_consultation_edit&id=<?php echo $id_consultation; ?>" class="btn btn-secondary">Annuler</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>