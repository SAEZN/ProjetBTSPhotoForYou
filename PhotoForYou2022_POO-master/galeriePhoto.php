<?php include("include/entete.inc.php"); ?>
<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=photoforyou2', 'root', '');

// Inclure la classe Photo
require_once 'classes/PhotoClass.php';
require_once 'logs/logger.php';

// Récupération des photos depuis la base de données
$stmt = $pdo->query('SELECT * FROM photos');
$photosData = $stmt->fetchAll(PDO::FETCH_ASSOC);
$photos = [];

foreach ($photosData as $photoData) {
    // Récupération des données binaires de l'image
    $fileData = $photoData['file'];
    $photo = new Photo(
        $photoData['id'],
        $photoData['title'],
        $photoData['description'],
        $photoData['price'],
        $photoData['filename'],
        $photoData['date'],
        $fileData // Utilisation des données binaires de l'image
    );
    $photos[] = $photo;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie de photos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .photo-card {
            width: 300px;
            margin-bottom: 20px;
        }
        .photo-card img {
            width: 100%;
            height: auto;
            cursor: pointer; /* Ajout du curseur pointer pour indiquer que l'image est cliquable */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4 text-center">Galerie de photos</h1>
        <div class="row">
            <?php foreach ($photos as $photo): ?>
                <div class="col-md-4">
                    <div class="card photo-card">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($photo->getFile()); ?>" class="card-img-top" alt="<?php echo $photo->getTitle(); ?>" data-bs-toggle="modal" data-bs-target="#photoModal-<?php echo $photo->getId(); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $photo->getTitle(); ?></h5>
                            <p class="card-text"><?php echo $photo->getDescription(); ?></p>
                            <p class="card-text"><?php echo $photo->getPrice() . " €"; ?></p>
                            <p class="card-text"><?php echo $photo->getDate(); ?></p>
                            <!-- Bouton d'achat -->
                            <a href="ajouterAuPanier.php?photoId=<?php echo $photo->getId(); ?>" class="btn btn-primary">Acheter</a>
                            <?php 
                                // Afficher le bouton de suppression uniquement pour les utilisateurs ayant le rôle d'administrateur
                                if ($_SESSION['login'] && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'photographe')) {
                                    echo '<button class="btn btn-danger" onclick="deletePhoto('.$photo->getId().')">Supprimer</button>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <?php 
                // Afficher le lien pour ajouter une nouvelle photo uniquement pour les utilisateurs ayant le rôle d'administrateur ou de photographe
                if ($_SESSION['login'] && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'photographe')) {
                    echo '<a href="ajoutPhoto.php" class="btn btn-primary">Ajouter une nouvelle photo</a>';
                }
            ?>
        </div>
    </div>
    
    <!-- Modals pour afficher les photos en grand -->
    <?php foreach ($photos as $photo): ?>
        <div class="modal fade" id="photoModal-<?php echo $photo->getId(); ?>" tabindex="-1" aria-labelledby="photoModalLabel-<?php echo $photo->getId(); ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="photoModalLabel-<?php echo $photo->getId(); ?>"><?php echo $photo->getTitle(); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($photo->getFilename()); ?>" class="img-fluid" alt="<?php echo $photo->getTitle(); ?>">
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
    function deletePhoto(photoId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette photo ?")) {
            // Envoi de la requête AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "supprimerPhoto.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Rechargement de la page après la suppression
                    window.location.reload();
                }
            };
            xhr.send("photoId=" + photoId);
        }
    }
</script>
</body>
</html>