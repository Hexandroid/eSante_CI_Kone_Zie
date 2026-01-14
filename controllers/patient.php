<?php
// Contrôleur pour les fonctionnalités patient

require_once __DIR__ . '/../config/database.php';

// Récupérer le dossier médical d'un patient
function get_dossier_patient($id_patient) {
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

// Récupérer toutes les consultations d'un patient
function get_consultations_patient($id_patient) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT c.*, u.nom as medecin_nom, u.prenom as medecin_prenom, m.specialite
        FROM consultations c
        JOIN medecins me ON c.id_medecin = me.id_medecin
        JOIN users u ON me.id_user = u.id_user
        LEFT JOIN medecins m ON me.id_medecin = m.id_medecin
        WHERE c.id_patient = ?
        ORDER BY c.date_consultation DESC
    ");
    $stmt->execute([$id_patient]);
    
    return $stmt->fetchAll();
}

// Récupérer toutes les ordonnances d'un patient
function get_ordonnances_patient($id_patient) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT o.*, c.date_consultation, u.nom as medecin_nom, u.prenom as medecin_prenom
        FROM ordonnances o
        JOIN consultations c ON o.id_consultation = c.id_consultation
        JOIN medecins m ON c.id_medecin = m.id_medecin
        JOIN users u ON m.id_user = u.id_user
        WHERE c.id_patient = ?
        ORDER BY o.date_ordonnance DESC
    ");
    $stmt->execute([$id_patient]);
    
    return $stmt->fetchAll();
}

// Récupérer une consultation spécifique
function get_consultation_detail($id_consultation, $id_patient) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT c.*, u.nom as medecin_nom, u.prenom as medecin_prenom, m.specialite
        FROM consultations c
        JOIN medecins me ON c.id_medecin = me.id_medecin
        JOIN users u ON me.id_user = u.id_user
        LEFT JOIN medecins m ON me.id_medecin = m.id_medecin
        WHERE c.id_consultation = ? AND c.id_patient = ?
    ");
    $stmt->execute([$id_consultation, $id_patient]);
    
    return $stmt->fetch();
}

// Récupérer une ordonnance spécifique
function get_ordonnance_detail($id_ordonnance, $id_patient) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT o.*, c.date_consultation, c.diagnostic, u.nom as medecin_nom, u.prenom as medecin_prenom
        FROM ordonnances o
        JOIN consultations c ON o.id_consultation = c.id_consultation
        JOIN medecins m ON c.id_medecin = m.id_medecin
        JOIN users u ON m.id_user = u.id_user
        WHERE o.id_ordonnance = ? AND c.id_patient = ?
    ");
    $stmt->execute([$id_ordonnance, $id_patient]);
    
    return $stmt->fetch();
}
?>