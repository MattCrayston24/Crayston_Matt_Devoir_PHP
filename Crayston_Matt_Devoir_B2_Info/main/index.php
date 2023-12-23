<?php
require_once '../dal/dal.php';

// Initialisation par défaut
$resultMessage = ['success' => false, 'message' => 'Aucune action spécifiée.'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['action']) && $_GET['action'] == 'add') {
        $nom = filter_input(INPUT_GET, 'nom', FILTER_SANITIZE_STRING);
        $prenom = filter_input(INPUT_GET, 'prenom', FILTER_SANITIZE_STRING);
        $age = filter_input(INPUT_GET, 'age', FILTER_VALIDATE_INT);

        if ($nom && $prenom && $age !== false) {
            $dal = new DAL();
            $dal->insert('utilisateurs', ['nom' => $nom, 'prenom' => $prenom, 'age' => $age]);

            $resultMessage = ['success' => true, 'message' => 'Utilisateur ajouté avec succès.'];
        } else {
            $resultMessage = ['success' => false, 'message' => 'Veuillez fournir des données valides.'];
        }
    } elseif (isset($_GET['action']) && $_GET['action'] == 'delete') {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id !== false) {
            $dal = new DAL();
            $dal->delete('utilisateurs', $id);

            $resultMessage = ['success' => true, 'message' => 'Utilisateur supprimé avec succès.'];
        } else {
            $resultMessage = ['success' => false, 'message' => 'Veuillez fournir un ID valide.'];
        }
    } elseif (isset($_GET['action']) && $_GET['action'] == 'edit') {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $nom = filter_input(INPUT_GET, 'nom', FILTER_SANITIZE_STRING);
        $prenom = filter_input(INPUT_GET, 'prenom', FILTER_SANITIZE_STRING);
        $age = filter_input(INPUT_GET, 'age', FILTER_VALIDATE_INT);

        if ($id !== false && $nom && $prenom && $age !== false) {
            $dal = new DAL();
            $dal->update('utilisateurs', $id, ['nom' => $nom, 'prenom' => $prenom, 'age' => $age]);

            $resultMessage = ['success' => true, 'message' => 'Utilisateur modifié avec succès.'];
        } else {
            $resultMessage = ['success' => false, 'message' => 'Veuillez fournir des données valides pour la mise à jour.'];
        }
    } elseif (isset($_GET['action']) && $_GET['action'] == 'read') {
        $dal = new DAL();
        $users = $dal->selectAll('utilisateurs');
        $resultMessage = ['success' => true, 'data' => $users];
    }
}

echo json_encode($resultMessage);
?>