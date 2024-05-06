<?php
  // Gestion de la session
  if (!isset($_SESSION)) {
    session_start();
  }
  if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = False;
  }

  require_once('connection.inc.php');
  require_once("mesFonctions.inc.php");

  // Pour le chargement automatique des classes
  function chargerClasse($classname)
  {
    require 'classes/' . $classname . '.class.php';
  }
  spl_autoload_register('chargerClasse');

  $manager = new UserManager($db);

  if (isset($_POST['deconnexion'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>PhotoForYou</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Liaison au fichier css de Bootstrap -->
  <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">
  <style>
    .carousel-item {
      width: 100%;
      height: auto;
      background-color: #5f666d;
      color: white;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Accueil</a>
      <a class="navbar-brand" href="galeriePhoto.php">Galerie photos</a>
      <a class="navbar-brand" href="panier.php">Panier</a>
      <div class="navbar-nav">
        <?php
          if ($_SESSION['login']) {
            echo '<span class="navbar-text">Bienvenue!</span>';
            echo '<form class="d-flex" method="post" action=""><input type="submit" name="deconnexion" value="Déconnexion" class="btn btn-outline-light"></form>';
          } else {
            echo '<a href="connexion.php" class="btn btn-outline-light">Connexion</a>';
            echo '<a href="inscription.php" class="btn btn-outline-light">S\'inscrire</a>';
          }
        ?>
      </div>
    </div>
  </nav>
</body>
</html>