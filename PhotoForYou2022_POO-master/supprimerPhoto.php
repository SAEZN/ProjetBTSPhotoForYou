<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=photoforyou2', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs

require_once 'logs/logger.php';

// Vérification de la requête AJAX et de l'ID de la photo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photoId'])) {
    $photoId = $_POST['photoId'];

    // Récupérer le rôle de l'utilisateur depuis la session
    session_start();
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        // L'utilisateur n'est pas connecté, renvoyer une erreur
        http_response_code(403);
        logError("L'utilisateur doit être connecté pour effectuer cette action.");
        echo "Vous devez être connecté pour effectuer cette action.";
        exit();
    }

    // Récupérer le rôle de l'utilisateur depuis la session
    $userRole = $_SESSION['role'];

    // Vérifier si l'utilisateur a le droit de supprimer une photo
    if ($userRole !== 'admin') {
        // L'utilisateur n'a pas les autorisations nécessaires, renvoyer une erreur
        http_response_code(403);
        logError("L'utilisateur n'a pas les autorisations nécessaires pour supprimer une photo.");
        echo "Vous n'avez pas les autorisations nécessaires pour supprimer une photo.";
        exit();
    }

    // Sélection de la photo à supprimer
    $sqlSelect = "SELECT * FROM photos WHERE id = :id";
    $stmtSelect = $pdo->prepare($sqlSelect);
    $stmtSelect->bindValue(':id', $photoId);
    $stmtSelect->execute();
    $photoData = $stmtSelect->fetch(PDO::FETCH_ASSOC);

    // Suppression de la photo de la base de données
    $sqlDelete = "DELETE FROM photos WHERE id = :id";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->bindValue(':id', $photoId);
    $stmtDelete->execute();

    // Enregistrer le succès de la suppression dans les logs
    logMessage("Photo supprimée avec succès.");
    echo "Photo supprimée avec succès.";
} else {
    // Requête invalide, renvoyer une erreur
    http_response_code(400);
    logError("Requête invalide.");
    echo "Requête invalide.";
}
?>