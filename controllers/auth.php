<?php
// Contrôleur pour l'authentification

// Démarrer la session uniquement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

// Fonction d'inscription
function inscription($nom, $prenom, $email, $password, $role, $extra_data = [])
{
    global $pdo;

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id_user FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        return ['success' => false, 'message' => 'Cet email est déjà utilisé.'];
    }

    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo->beginTransaction();

        // Insérer l'utilisateur
        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $hashed_password, $role]);
        $id_user = $pdo->lastInsertId();

        // Si c'est un patient, créer le dossier patient
        if ($role === 'patient') {
            $stmt = $pdo->prepare("INSERT INTO patients (id_user, date_naissance, sexe, groupe_sanguin, allergies, antecedents) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $id_user,
                $extra_data['date_naissance'] ?? null,
                $extra_data['sexe'] ?? 'M',
                $extra_data['groupe_sanguin'] ?? null,
                $extra_data['allergies'] ?? null,
                $extra_data['antecedents'] ?? null
            ]);
        }

        // Si c'est un médecin, créer le profil médecin
        if ($role === 'medecin') {
            $stmt = $pdo->prepare("INSERT INTO medecins (id_user, specialite) VALUES (?, ?)");
            $stmt->execute([$id_user, $extra_data['specialite'] ?? 'Généraliste']);
        }

        $pdo->commit();
        return ['success' => true, 'message' => 'Inscription réussie !'];
    } catch (Exception $e) {
        $pdo->rollBack();
        return ['success' => false, 'message' => 'Erreur lors de l\'inscription : ' . $e->getMessage()];
    }
}

// Fonction de connexion
function connexion($email, $password)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Connexion réussie, créer la session
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Récupérer l'id spécifique (patient ou médecin)
        if ($user['role'] === 'patient') {
            $stmt = $pdo->prepare("SELECT id_patient FROM patients WHERE id_user = ?");
            $stmt->execute([$user['id_user']]);
            $patient = $stmt->fetch();
            $_SESSION['id_patient'] = $patient['id_patient'];
        } elseif ($user['role'] === 'medecin') {
            $stmt = $pdo->prepare("SELECT id_medecin FROM medecins WHERE id_user = ?");
            $stmt->execute([$user['id_user']]);
            $medecin = $stmt->fetch();
            $_SESSION['id_medecin'] = $medecin['id_medecin'];
        }

        return ['success' => true, 'role' => $user['role']];
    } else {
        return ['success' => false, 'message' => 'Email ou mot de passe incorrect.'];
    }
}

// Fonction de déconnexion
function deconnexion()
{
    session_destroy();
    header('Location: /eSante-CI/public/index.php');
    exit();
}

// Fonction pour vérifier si l'utilisateur est connecté
function est_connecte()
{
    return isset($_SESSION['user_id']);
}

// Fonction pour vérifier le rôle
function verifier_role($role_requis)
{
    if (!est_connecte() || $_SESSION['role'] !== $role_requis) {
        header('Location: /eSante-CI/public/index.php?page=login');
        exit();
    }
}
