<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=photoforyou2', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs

// Vérification de la requête AJAX et de l'ID de la photo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photoId'])) {
    $photoId = $_POST['photoId'];

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

    // Suppression de la photo du dossier "uploads"
    $uploadDirectory = 'uploads/';
    $filename = $photoData['filename'];
    unlink($uploadDirectory . $filename);

    echo "Photo supprimée avec succès.";
}
?>