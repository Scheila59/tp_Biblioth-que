<?php ob_start() ;?>

<?php if (isset($_SESSION['erreurs'])) {
    foreach ($_SESSION['erreurs'] as $erreursTab) {
        foreach ($erreursTab as $erreurs) {
            $divErreur = "<div class='alert alert-danger w-100 m-auto' style='max-width:781px'><ul>";
            foreach ($erreurs as $erreur) {
                $divErreur .= "<li>$erreur</li>";
            }
            $divErreur .= '</ul></div>';
            unset($_SESSION['erreurs']);
            echo $divErreur;
        }
    }
} ?>

<form method="POST" action="<?= SITE_URL ?>livres/av" enctype="multipart/form-data">
    <div class="form-group my-4" >
        <label for="titre">Titre : </label>
        <input type="text" class="form-control" id="titre" name="titre">
    </div>
    <div class="form-group my-4" >
        <label for="nbre-de-pages">Nombre de pages : </label>
        <input type="text" class="form-control" id="nbre-de-pages" name="nbre-de-pages">
    </div>
    <div class="form-group my-4" >
        <label for="text-alternatif">Description de l'image : </label>
        <textarea class="form-control" id="text-alternatif" name="text-alternatif"></textarea>
    </div>
    <div class="form-group my-4" >
        <label for="image">Image : </label>
        <input type="file" class="form-control" id="image" name="image"></input>
    </div>
    <img src="" id="image-preview" style='max-width:80%;' alt="">
    <button class="btn btn-secondary">Créer livre</button>
</form>

<?php
$titre = "Ajout d'un livre";
$content = ob_get_clean();
require_once 'template.php';