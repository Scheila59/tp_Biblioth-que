<?php ob_start(); ?>

<?php require '../app/Views/showErreurs.php'; ?> <!-- afficher les erreurs -->

<form method="POST" action="<?= SITE_URL ?>livres/av" enctype="multipart/form-data"> <!-- créer un formulaire pour ajouter un livre -->
    <div class="form-group my-4"> <!-- créer un champ pour le titre -->
        <label for="titre">Titre : </label> <!-- créer un label pour le champ -->
        <input type="text" class="form-control" id="titre" name="titre"> <!-- créer un champ pour le titre -->
    </div>
    <div class="form-group my-4">
        <label for="nbre-de-pages">Nombre de pages : </label>
        <input type="text" class="form-control" id="nbre-de-pages" name="nbre-de-pages">
    </div>
    <div class="form-group my-4"> <!-- créer un champ pour la description de l'image -->
        <label for="text-alternatif">Description de l'image : </label> <!-- créer un label pour le champ -->
        <textarea class="form-control" id="text-alternatif" name="text-alternatif"></textarea> <!-- créer un champ pour la description de l'image -->
    </div>
    <div class="form-group my-4"> <!-- créer un champ pour l'image -->
        <label for="image">Image : </label> <!-- créer un label pour le champ -->
        <input type="file" class="form-control" id="image" name="image"></input> <!-- créer un champ pour l'image -->
    </div>
    <img src="" id="image-preview" style='max-width:80%;' alt=""> <!-- afficher l'image -->
    <?= $csrfToken ?>
    <button class="btn btn-secondary">Créer livre</button> <!-- créer un bouton pour créer le livre -->
</form>

<?php
$titre = "Ajout d'un livre"; // définir le titre de la page
$content = ob_get_clean(); // nettoyer le tampon de sortie
require_once 'template.php'; // inclure le template
