<?php
// Contrôleur pour les fonctionnalités médecin

require_once __DIR__ . '/../config/database.php';

// Récupérer tous les patients
function get_all_patients() {
    global $pdo;
    
    $stmt = $pdo->query("
        SELECT p.*, u.nom, u.prenom, u.email 
        FROM patients p
        JOIN users u ON p.id_user = u.id_user
        ORDER BY u.nom, u.prenom
    ");
    
    return $stmt->fetchAll();
}

// Récupérer un patient spécifique
function get_patient_by_id($id_patient) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT p.*, u.nom, u.prenom, u.email 
        FROM patients p
        JOIN users u ON p.id_user = u.id_user
        WHERE p.id_patient = ?
    ");
    $stmt->execute([$id_patient]);
    
    return $stmt->fetch();
}

// Mettre à jour le dossier d'un patient
function update_patient($id_patient, $data) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            UPDATE patients 
            SET date_naissance = ?, sexe = ?, groupe_sanguin = ?, allergies = ?, antecedents = ?
            WHERE id_patient = ?
        ");
        
        $stmt->execute([
            $data['date_naissance'],
            $data['sexe'],
            $data['groupe_sanguin'],
            $data['allergies'],
            $data['antecedents'],
            $id_patient
        ]);
        
        return ['success' => true, 'message' => 'Dossier patient mis à jour avec succès.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()];
    }
}

// Récupérer les consultations d'un médecin
function get_consultations_medecin($id_medecin) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT c.*, u.nom as patient_nom, u.prenom as patient_prenom
        FROM consultations c
        JOIN patients p ON c.id_patient = p.id_patient
        JOIN users u ON p.id_user = u.id_user
        WHERE c.id_medecin = ?
        ORDER BY c.date_consultation DESC
    ");
    $stmt->execute([$id_medecin]);
    
    return $stmt->fetchAll();
}

// Récupérer une consultation spécifique
function get_consultation_medecin($id_consultation, $id_medecin) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT c.*, u.nom as patient_nom, u.prenom as patient_prenom, p.date_naissance, p.groupe_sanguin
        FROM consultations c
        JOIN patients p ON c.id_patient = p.id_patient
        JOIN users u ON p.id_user = u.id_user
        WHERE c.id_consultation = ? AND c.id_medecin = ?
    ");
    $stmt->execute([$id_consultation, $id_medecin]);
    
    return $stmt->fetch();
}
?>