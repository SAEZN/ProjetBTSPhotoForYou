<?php

function generationEntete(string $titre, string $sous_titre): string
{
  // Voir pour le traitement si besoins des chaines
  return '<div class="py-5 text-center">
                <img class="d-block mx-auto mb-2" src="images/logo.png" alt="logo photoforyou" width="170" height="115">
                <h1 class="display-5">'.$titre.'</h1>
                <p class="lead">'.$sous_titre.'</p>
          </div>';
}
function generationOptions(string $titre,  string $libelle,string $url_image="s-l500.jpg", string $lien='#', string $titre_boutons="Gérer"): string
{
  return '
  <div class="col">
        <div class="card" style="width: 18rem;">
          <img src="images/'. $url_image. '" class="img-top" alt="'.$libelle.'">
          <div class="card-body">
            <h5 class="card-title">'. $titre .'</h5>
            <p class="card-text">'. $libelle .'</p>
            <a href="'. $lien. '" class="w-100 btn btn-lg btn-outline-primary">'. $titre_boutons. '</a>
          </div>
        </div>
  </div>';
}
/**
 * Génère le code HTML avec Bootstrap pour les options dans une page
 *
 * @param  string Titre de l'option
 * @param  string texte qui figure en dessous de l'image
 * @param  string Url de l'image (ex : images/imagesCarte/gestionEngin.jpeg )
 * @param  string Url où va pointer le bouton
 * @param  string Titre du bouton (falcultatif) Go si pas renseigné 
 * @return string Retourne le code HTML 
 */
function generationPhotosPaysages(string $titre,  string $libelle,string $url_image="", string $lien='#', string $titre_boutons="Récuperer"): string
{
  return '
  <div class="col">
        <div class="card" style="width: 18rem;">
          <img src="images/imagesPaysages/'. $url_image. '" class="card-img-top" alt="'.$libelle.'">
          <div class="card-body">
            <h5 class="card-title">'. $titre .'</h5>
            <p class="card-text">'. $libelle .'</p>
            <a href="'. $lien. '" class="w-100 btn btn-lg btn-outline-primary">'. $titre_boutons. '</a>
          </div>
        </div>
  </div>';
}
/**
 * Génère le code HTML avec Bootstrap pour les options dans une page
 *
 * @param  string Titre de l'option
 * @param  string texte qui figure en dessous de l'image
 * @param  string Url de l'image (ex : images/imagesCarte/gestionEngin.jpeg )
 * @param  string Url où va pointer le bouton
 * @param  string Titre du bouton (falcultatif) Go si pas renseigné 
 * @return string Retourne le code HTML 
 */
function generationPhotosPortraits(string $titre,  string $libelle,string $url_image="", string $lien='#', string $titre_boutons="Récuperer"): string
{
  return '
  <div class="col">
        <div class="card" style="width: 18rem;">
          <img src="images/imagesPortraits/'. $url_image. '" class="card-img-top" alt="'.$libelle.'">
          <div class="card-body">
            <h5 class="card-title">'. $titre .'</h5>
            <p class="card-text">'. $libelle .'</p>
            <a href="'. $lien. '" class="w-100 btn btn-lg btn-outline-primary">'. $titre_boutons. '</a>
          </div>
        </div>
  </div>';
}
/**
 * Génère le code HTML avec Bootstrap pour les options dans une page
 *
 * @param  string Titre de l'option
 * @param  string texte qui figure en dessous de l'image
 * @param  string Url de l'image (ex : images/imagesCarte/gestionEngin.jpeg )
 * @param  string Url où va pointer le bouton
 * @param  string Titre du bouton (falcultatif) Go si pas renseigné 
 * @return string Retourne le code HTML 
 */
function generationPhotosEvents(string $titre,  string $libelle,string $url_image="", string $lien='#', string $titre_boutons="Récuperer"): string
{
  return '
  <div class="col">
        <div class="card" style="width: 18rem;">
          <img src="images/imagesEvents/'. $url_image. '" class="card-img-top" alt="'.$libelle.'">
          <div class="card-body">
            <h5 class="card-title">'. $titre .'</h5>
            <p class="card-text">'. $libelle .'</p>
            <a href="'. $lien. '" class="w-100 btn btn-lg btn-outline-primary">'. $titre_boutons. '</a>
          </div>
        </div>
  </div>';
}