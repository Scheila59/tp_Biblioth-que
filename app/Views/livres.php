<?php ob_start() ?> <!-- démarrer la temporisation de sortie -->

<?php if(!$pasDeLivre) : ?> <!-- si il y a des livres -->
<?php require '../app/Views/showAlert.php'; ?>
<table class="table test-center"> <!-- créer un tableau -->
    <tr class="table-dark"> <!-- créer une ligne -->
        <th>Image</th> <!-- créer une colonne -->
        <th>Titre</th> <!-- créer une colonne -->
        <th>Nombre de pages</th> <!-- créer une colonne -->
        <th colspan="2">Actions</th> <!-- créer une colonne -->
    </tr>
    <?php
    // $livresTab = $repositoryLivres->getLivres();  
     foreach($livresTab as $livre) : ?> 
         <!-- : => signifie en attente de la fermeture  -->
    <tr>
        <td class="align-middle"><img src="images/<?= $livre->getUrlImage(); ?>" style="height: 60px;" ; alt="<?= $livre->getTextAlternatif(); ?>"></td> <!-- afficher l'image du livre -->
        <td class="align-middle">
            <a href="<?= SITE_URL ?>livres/l/<?= $livre->getId() ?>"><?= $livre->getTitre() ?></a>
        </td>
        <td class="align-middle"><?= $livre->getNbreDePages(); ?> </td> <!-- afficher le nombre de pages du livre -->
        <td class="align-middle">
            <a href="<?= SITE_URL ?>livres/m/<?= $livre->getId() ?>" class="btn btn-warning">Modifier</a> <!-- créer un lien pour modifier le livre -->
        </td>
        <td class="align-middle">
            <form method="post" action="<?= SITE_URL ?>livres/s/<?= $livre->getId() ?>" onSubmit="return confirm('Voulez-vous vraiment supprimer le livre <?= $livre->getId(); ?> ?');">
                <button class="btn btn-danger">Supprimer</button>
            </form>  
        </td>
    </tr>
    <?php endforeach; ?> 
    <!-- // fermeture -->
</table>
<a href="<?= SITE_URL ?>livres/a" class="btn btn-success d-block w-100">Ajouter</a> <!-- créer un lien pour ajouter un livre -->
<?php else : ?>
    <div class="d-flex flex-column">
        <div class="card text-white bg-info mb-3" style="max-width: 20rem;"> <!-- créer une carte -->
            <div class="card-header">Votre espace</div> <!-- créer un en-tête -->
            <div class="card-body">
                <h4 class="card-title">Désolé</h4> <!-- créer un titre -->
                <p class="card-text">Il semble que vous n'ayez pas encore uploadé de livre dans votre espace.</p> <!-- créer un paragraphe -->
                <p class="card-text">Pour y remédier, utilisez le bouton ci-dessous...</p> <!-- créer un paragraphe -->
            </div>
        </div>
        <a href="<?= SITE_URL ?>livres/a" class="btn btn-success d-block w-100">Ajouter</a>
    </div>
    <?php endif; ?>
<?php


$titre = "Livres"; // définir le titre de la page
$content = ob_get_clean(); // nettoyer le tampon de sortie
require_once 'template.php'; // inclure le template
