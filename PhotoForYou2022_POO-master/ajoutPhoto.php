<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=photoforyou2', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs
// Classe Photo pour représenter une photo (votre classe existante)
require_once 'classes/PhotoClass.php';

// Traitement du formulaire d'ajout de photo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $id = 1;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file = $_FILES['file'];
    $filename = $_FILES['file']['name'];
    $date = date('Y-m-d'); // Obtient la date au format 'AAAA-MM-JJ'
    
    // Création d'un objet Photo
    $photo = new Photo($id, $title, $description, $filename, $date, $file);

    // Enregistrement de la photo dans la base de données
    $photo->saveToDatabase($pdo);

    // Redirection vers la galerie de photosS
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une photo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter une photo</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Titre :</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="file">Fichier :</label>
                <input type="file" class="form-control-file" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>