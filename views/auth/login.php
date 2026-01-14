<?php
$error = '';
$success = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        $result = connexion($email, $password);
        
        if ($result['success']) {
            // Redirection selon le rôle
            if ($result['role'] === 'patient') {
                header('Location: /eSante-CI/public/index.php?page=patient_dashboard');
            } else {
                header('Location: /eSante-CI/public/index.php?page=doctor_dashboard');
            }
            exit();
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
    <title>Connexion - eSanté-CI</title>
    <link rel="stylesheet" href="/eSante-CI/public/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>eSanté-CI</h1>
        </div>
    </header>

    <div class="container">
        <div class="card" style="max-width: 500px; margin: 0 auto;">
            <h2>Connexion</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn">Se connecter</button>
                <a href="/eSante-CI/public/index.php?page=register" class="btn btn-secondary">S'inscrire</a>
                <a href="/eSante-CI/public/index.php" class="btn btn-secondary">Retour</a>
            </form>
        </div>
    </div>
</body>
</html>