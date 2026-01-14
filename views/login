<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - eSanté-CI</title>
</head>
<body>
    <h2>Connexion (mode démonstration)</h2>

    <form method="post">
        <label>Choisir un rôle :</label><br><br>
        <select name="role">
            <option value="patient">Patient</option>
            <option value="medecin">Médecin</option>
        </select>
        <br><br>
        <button type="submit">Se connecter</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['user'] = true;
        $_SESSION['prenom'] = 'Utilisateur';
        $_SESSION['nom'] = 'Démo';
        $_SESSION['role'] = $_POST['role'];

        header('Location: /');
        exit;
    }
    ?>
</body>
</html>
