<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=photoforyou2', 'root', '');

// Inclure la classe Photo
require_once 'classes/PhotoClass.php';

// Récupération des photos depuis la base de données
$stmt = $pdo->query('SELECT * FROM photos');
$photosData = $stmt->fetchAll(PDO::FETCH_ASSOC);
$photos = [];

foreach ($photosData as $photoData) {
    $photo = new Photo(
        $photoData['id'],
        $photoData['title'],
        $photoData['description'],
        $photoData['filename'],
        $photoData['date'],
        $photoData['file']
    );
    $photos[] = $photo;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Galerie de photos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Galerie de photos</h1>
    <?php foreach ($photos as $photo): ?>
        <div>
            <img src="uploads/<?php echo $photo->getFilename(); ?>" alt="<?php echo $photo->getTitle(); ?>">
            <h2><?php echo $photo->getTitle(); ?></h2>
            <p><?php echo $photo->getDescription(); ?></p>
            <p><?php echo $photo->getDate(); ?></p>
            <p><?php echo $photo->getFile(); ?></p>
            <button class="btn btn-danger" onclick="deletePhoto(<?php echo $photo->getId(); ?>)">Supprimer</button>
        </div>
    <?php endforeach; ?>
    <br>
    <a href="ajoutPhoto.php">Ajouter une nouvelle photo</a>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script> function deletePhoto(photoId) {
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