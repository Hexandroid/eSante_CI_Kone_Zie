<?php
// Contrôleur pour les ordonnances

require_once __DIR__ . '/../config/database.php';

// Créer une ordonnance
function create_ordonnance($id_consultation, $date_ordonnance, $medicaments, $posologie) {
    global $pdo;
    
    try {
        // Vérifier que la consultation existe
        $stmt = $pdo->prepare("SELECT id_consultation FROM consultations WHERE id_consultation = ?");
        $stmt->execute([$id_consultation]);
        
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Consultation non trouvée.'];
        }
        
        $stmt = $pdo->prepare("
            INSERT INTO ordonnances (id_consultation, date_ordonnance, medicaments, posologie)
            VALUES (?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $id_consultation,
            $date_ordonnance,
            $medicaments,
            $posologie
        ]);
        
        return ['success' => true, 'message' => 'Ordonnance créée avec succès.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la création : ' . $e->getMessage()];
    }
}

// Récupérer une ordonnance par consultation
function get_ordonnance_by_consultation($id_consultation) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT o.*
        FROM ordonnances o
        WHERE o.id_consultation = ?
    ");
    $stmt->execute([$id_consultation]);
    
    return $stmt->fetch();
}

// Mettre à jour une ordonnance
function update_ordonnance($id_ordonnance, $medicaments, $posologie) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            UPDATE ordonnances 
            SET medicaments = ?, posologie = ?
            WHERE id_ordonnance = ?
        ");
        
        $stmt->execute([
            $medicaments,
            $posologie,
            $id_ordonnance
        ]);
        
        return ['success' => true, 'message' => 'Ordonnance mise à jour avec succès.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()];
    }
}

// Supprimer une ordonnance
function delete_ordonnance($id_ordonnance) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("DELETE FROM ordonnances WHERE id_ordonnance = ?");
        $stmt->execute([$id_ordonnance]);
        
        return ['success' => true, 'message' => 'Ordonnance supprimée avec succès.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la suppression : ' . $e->getMessage()];
    }
}
?>