<?php
session_start();

// Vérifiez si l'utilisateur est connecté ou identifié
if (isset($_SESSION['utilisateur_id'])) {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=photoforyou2', 'root', '');

    // Récupérez l'ID de l'utilisateur depuis la session
    $utilisateurId = $_SESSION['utilisateur_id'];

    // Vérifiez si l'ID de la photo est fourni en tant que paramètre dans l'URL
    if (isset($_GET['photoId'])) {
        // Récupérez l'ID de la photo depuis le paramètre d'URL
        $photoId = $_GET['photoId'];

        // Préparez et exécutez la requête d'insertion dans la table panier
        $stmt = $pdo->prepare("INSERT INTO panier (utilisateur_id, photo_id) VALUES (:utilisateur_id, :photo_id)");
        $stmt->bindParam(':utilisateur_id', $utilisateurId);
        $stmt->bindParam(':photo_id', $photoId);
        $stmt->execute();
    }
}

// Redirigez l'utilisateur vers la page du panier
header('Location: panier.php');
exit();
?>