<?php
$error = '';
$success = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $role = $_POST['role'];
    
    // Validation
    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($role)) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } elseif ($password !== $password_confirm) {
        $error = 'Les mots de passe ne correspondent pas.';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères.';
    } else {
        // Données supplémentaires selon le rôle
        $extra_data = [];
        
        if ($role === 'patient') {
            $extra_data = [
                'date_naissance' => $_POST['date_naissance'] ?? null,
                'sexe' => $_POST['sexe'] ?? 'M',
                'groupe_sanguin' => $_POST['groupe_sanguin'] ?? null,
                'allergies' => $_POST['allergies'] ?? null,
                'antecedents' => $_POST['antecedents'] ?? null
            ];
        } elseif ($role === 'medecin') {
            $extra_data = [
                'specialite' => $_POST['specialite'] ?? 'Généraliste'
            ];
        }
        
        $result = inscription($nom, $prenom, $email, $password, $role, $extra_data);
        
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
    <title>Inscription - eSanté-CI</title>
    <link rel="stylesheet" href="/eSante-CI/public/css/style.css">
    <script>
        function toggleRoleFields() {
            const role = document.getElementById('role').value;
            document.getElementById('patient-fields').style.display = role === 'patient' ? 'block' : 'none';
            document.getElementById('medecin-fields').style.display = role === 'medecin' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <header>
        <div class="container">
            <h1>eSanté-CI</h1>
        </div>
    </header>

    <div class="container">
        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <h2>Inscription</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                    <a href="/eSante-CI/public/index.php?page=login">Se connecter maintenant</a>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="role">Je suis *</label>
                    <select id="role" name="role" required onchange="toggleRoleFields()">
                        <option value="">Sélectionnez...</option>
                        <option value="patient">Patient</option>
                        <option value="medecin">Médecin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                
                <div class="form-group">
                    <label for="prenom">Prénom *</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe * (min. 6 caractères)</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="password_confirm">Confirmer le mot de passe *</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>
                
                <!-- Champs spécifiques aux patients -->
                <div id="patient-fields" style="display: none;">
                    <h3>Informations patient</h3>
                    
                    <div class="form-group">
                        <label for="date_naissance">Date de naissance</label>
                        <input type="date" id="date_naissance" name="date_naissance">
                    </div>
                    
                    <div class="form-group">
                        <label for="sexe">Sexe</label>
                        <select id="sexe" name="sexe">
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="groupe_sanguin">Groupe sanguin</label>
                        <input type="text" id="groupe_sanguin" name="groupe_sanguin" placeholder="Ex: A+, O-, AB+...">
                    </div>
                    
                    <div class="form-group">
                        <label for="allergies">Allergies</label>
                        <textarea id="allergies" name="allergies" placeholder="Liste des allergies connues..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="antecedents">Antécédents médicaux</label>
                        <textarea id="antecedents" name="antecedents" placeholder="Antécédents médicaux importants..."></textarea>
                    </div>
                </div>
                
                <!-- Champs spécifiques aux médecins -->
                <div id="medecin-fields" style="display: none;">
                    <h3>Informations médecin</h3>
                    
                    <div class="form-group">
                        <label for="specialite">Spécialité</label>
                        <input type="text" id="specialite" name="specialite" placeholder="Ex: Généraliste, Cardiologue...">
                    </div>
                </div>
                
                <button type="submit" class="btn">S'inscrire</button>
                <a href="/eSante-CI/public/index.php?page=login" class="btn btn-secondary">J'ai déjà un compte</a>
                <a href="/eSante-CI/public/index.php" class="btn btn-secondary">Retour</a>
            </form>
        </div>
    </div>
</body>
</html>