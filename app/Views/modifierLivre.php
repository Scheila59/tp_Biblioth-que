<?php ob_start() ?>

<?php require '../app/Views/showErreurs.php'; ?> <!-- afficher les erreurs -->

<form method="POST" action="<?= SITE_URL ?>livres/mv" enctype="multipart/form-data"> <!-- créer un formulaire pour modifier le livre -->
    <div class="form-group my-4" > <!-- créer un champ pour le titre -->
        <label for="titre">Titre : </label> <!-- créer un label pour le champ -->
        <input type="text" value="<?= $livre->getTitre(); ?>" class="form-control" id="titre" name="titre"> <!-- créer un champ pour le titre -->
    </div>
    <div class="form-group my-4" > <!-- créer un champ pour le nombre de pages -->
        <label for="nbre-de-pages">Nombre de pages : </label> <!-- créer un label pour le champ -->
        <input type="text" value="<?= $livre->getNbreDePages(); ?>" class="form-control" id="nbre-de-pages" name="nbre-de-pages">
    </div>
    <div class="form-group my-4" > <!-- créer un champ pour la description de l'image -->
        <label for="text-alternatif">Description de l'image : </label> <!-- créer un label pour le champ -->
        <textarea class="form-control" id="text-alternatif" name="text-alternatif"><?= $livre->getTextAlternatif(); ?></textarea> <!-- créer un champ pour la description de l'image -->
    </div>
    <img id="image-preview" style='max-width:80%;' src="<?= SITE_URL ?>images/<?= $livre->getUrlImage(); ?>" alt="<?= $livre->getTextAlternatif(); ?>"> <!-- afficher l'image du livre -->
    <div class="form-group my-4" > <!-- créer un champ pour l'image -->
        <label for="image">Image : </label> <!-- créer un label pour le champ -->
        <input type="file" class="form-control" id="image" name="image"></input> <!-- créer un champ pour l'image -->
    </div>
    <input type="hidden" name="id_livre" value="<?= $livre->getId(); ?>"> <!-- créer un champ pour l'id du livre -->
    <?= $csrfToken ?>
    <button class="btn btn-secondary">Modifier le livre</button> <!-- créer un bouton pour modifier le livre -->
</form>

<?php
$titre = "Modifier le livre " . $livre->getTitre(); // définir le titre de la page
$content = ob_get_clean(); // nettoyer le tampon de sortie
require_once 'template.php'; // inclure le template
