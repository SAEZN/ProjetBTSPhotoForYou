<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=photoforyou2', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs
// Classe Photo pour représenter une photo (votre classe existante)
require_once 'classes/PhotoClass.php';
require_once 'logs/logger.php';

// Vérifier si l'utilisateur a le droit d'ajouter une photo
session_start();
if (!isset($_SESSION['login']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'photographe')) {
    // Rediriger vers une autre page ou afficher un message d'erreur
    echo "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
    exit();
}

// Traitement du formulaire d'ajout de photo        
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file = $_FILES['file'];
    $filename = $_FILES['file']['name'];
    $price = $_POST['price']; // Récupération du prix saisi par l'utilisateur
    $date = date('Y-m-d'); // Obtient la date au format 'AAAA-MM-JJ'

    // Le error msg Img trop grand, marche pas !!!
    // Vérification de la taille de l'image
    $maxFileSize = 5 * 1024 * 1024; // 5 Mo (en octets)
    $fileSize = $_FILES['file']['size'];
    if ($fileSize > $maxFileSize) {
        $errorMessage = "Désolé, l'image est trop grande. Veuillez sélectionner une image dont la taille est inférieure à 5 Mo.";
        logError($errorMessage, 'ajoutPhoto.php'); // Enregistrer l'erreur dans le journal avec le nom de la page
    } else {
        try {
            // Création d'un objet Photo
            $photo = new Photo(null, $title, $description, $price, $filename, $date, $file);

            // Enregistrement de la photo dans la base de données
            $photo->saveToDatabase($pdo);

            // Redirection vers la galerie de photos
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            $errorMessage = "Une erreur s'est produite lors de l'enregistrement de la photo. Veuillez réessayer plus tard.";
        }
    }
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
            <div class="form-group">
                <label for="price">Prix :</label>
                <input type="number" class="form-control" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>

        <!-- Message d'erreur -->
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger mt-3"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>