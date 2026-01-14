<?php
// Contrôleur pour les consultations

require_once __DIR__ . '/../config/database.php';

// Créer une nouvelle consultation
function create_consultation($id_patient, $id_medecin, $date_consultation, $symptomes, $diagnostic, $traitement) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO consultations (id_patient, id_medecin, date_consultation, symptomes, diagnostic, traitement)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $id_patient,
            $id_medecin,
            $date_consultation,
            $symptomes,
            $diagnostic,
            $traitement
        ]);
        
        $id_consultation = $pdo->lastInsertId();
        
        return ['success' => true, 'message' => 'Consultation créée avec succès.', 'id_consultation' => $id_consultation];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la création : ' . $e->getMessage()];
    }
}

// Mettre à jour une consultation
function update_consultation($id_consultation, $id_medecin, $symptomes, $diagnostic, $traitement) {
    global $pdo;
    
    try {
        // Vérifier que la consultation appartient bien au médecin
        $stmt = $pdo->prepare("SELECT id_consultation FROM consultations WHERE id_consultation = ? AND id_medecin = ?");
        $stmt->execute([$id_consultation, $id_medecin]);
        
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Consultation non trouvée ou accès non autorisé.'];
        }
        
        $stmt = $pdo->prepare("
            UPDATE consultations 
            SET symptomes = ?, diagnostic = ?, traitement = ?
            WHERE id_consultation = ?
        ");
        
        $stmt->execute([
            $symptomes,
            $diagnostic,
            $traitement,
            $id_consultation
        ]);
        
        return ['success' => true, 'message' => 'Consultation mise à jour avec succès.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()];
    }
}

// Supprimer une consultation
function delete_consultation($id_consultation, $id_medecin) {
    global $pdo;
    
    try {
        // Vérifier que la consultation appartient bien au médecin
        $stmt = $pdo->prepare("SELECT id_consultation FROM consultations WHERE id_consultation = ? AND id_medecin = ?");
        $stmt->execute([$id_consultation, $id_medecin]);
        
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Consultation non trouvée ou accès non autorisé.'];
        }
        
        $stmt = $pdo->prepare("DELETE FROM consultations WHERE id_consultation = ?");
        $stmt->execute([$id_consultation]);
        
        return ['success' => true, 'message' => 'Consultation supprimée avec succès.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la suppression : ' . $e->getMessage()];
    }
}
?>