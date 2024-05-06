<?php
include("include/entete.inc.php");

if (isset($_POST['identifier'])) {
    $user = $manager->getUser($_POST['mail']);
    if ($user) {
        if ($user->getMdp() == $_POST['motdepasse']) {
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['NomUtilisateur'] = $user->getPrenom();
            $_SESSION['role'] = $user->getRole();
            header('Location: membres.php'); // Rediriger vers la page des membres
            exit();
        } else {
            header('Location: index.php?error=1'); // Mauvais mot de passe
            exit();
        }
    } else {
        header('Location: index.php?error=2'); // Utilisateur non trouvé
        exit();
    }
}

?>
	<div class="container">
  <?php
  //formulaire de connexion
  echo generationEntete("Connexion", "Merci de vous identifier") ?>
    <div class="jumbotron">
    <form method="post" id="formId"  novalidate>
      <div class="form-group row">
        <div class="col-md-4 mb-3">
          <label for="email">Adresse électronique : </label>
          <input type="email" class= "form-control 
          <?php 
          if (isset($_POST['identifier']))
          {
            if (!$manager->getUser($_POST['mail'])) { echo " is-invalid"; } else  { echo " is-valid"; } 
          } 
          else
          {
            echo " is-valid";
          } 
          ?>
          " name="mail" id="email" placeholder="E-mail" required>
          <div class="invalid-feedback">
             <?php 
                if (isset($_POST['identifier']) && (!$manager->getUser($_POST['mail'])))
                {
                  echo " Le mail n'existe pas dans la base";  
                } 
                elseif (!isset($_POST['identifier']))
                {
                  echo " Vous devez fournir un mail valide";
                }
             ?>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-md-4 mb-3">
          <label for="motDePasse1">Mot de passe :</label>
          <input type="password" class="form-control" name="motdepasse" required>
        </div>
        <div class="invalid-feedback">
            Vous devez fournir un mot de passe.
        </div>
      </div>
      <input type="submit" value="Valider" class="btn btn-primary" name="identifier" />
    </form>
  </div>
  <script>
    // Validation du formulaire
    (function() {
        "use strict"
        window.addEventListener("load", function() {
            var form = document.getElementById("formId")
            form.addEventListener("submit", function(event) {
                if (form.checkValidity() == false) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add("was-validated")
            }, false)
        }, false)
    }())
</script>

<?php
include("include/piedDePage.inc.php");
?>