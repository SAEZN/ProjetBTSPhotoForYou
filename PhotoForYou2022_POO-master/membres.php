<?php
	include ("include/entete.inc.php");
	echo generationEntete("Page des utilisateurs", "Bonjour ".$_SESSION['NomUtilisateur']);
	include ("include/piedDePage.inc.php");
?>
