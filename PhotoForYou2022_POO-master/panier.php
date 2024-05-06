<?php include("include/entete.inc.php"); ?>

<?php
// Vérifiez si l'utilisateur est connecté ou identifié
if (isset($_SESSION['id'])) {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=photoforyou2', 'root', '');

    // Récupérez l'ID de l'utilisateur depuis la session
    $utilisateurId = $_SESSION['id'];

    // Récupérez les données de chaque photo dans le panier à partir de la base de données
    $sql = "SELECT photos.* FROM photos INNER JOIN panier ON photos.id = panier.photo_id WHERE panier.id = :utilisateur_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':utilisateur_id', $utilisateurId);
    $stmt->execute();
    $panierPhotos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion ou affichez un message d'erreur approprié
    // header('Location: page_de_connexion.php');
    // exit();
    echo "Vous devez être connecté pour accéder à votre panier.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4 text-center">Panier</h1>
        <?php if (!empty($panierPhotos)): ?>
            <div class="row">
                <?php foreach ($panierPhotos as $photo): ?>
                    <div class="col-md-4">
                        <div class="card photo-card">
                            <img src="uploads/<?php echo $photo['filename']; ?>" class="card-img-top" alt="<?php echo $photo['title']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $photo['title']; ?></h5>
                                <p class="card-text"><?php echo $photo['description']; ?></p>
                                <p class="card-text"><?php echo $photo['price']; ?> €</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                Votre panier est vide.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>