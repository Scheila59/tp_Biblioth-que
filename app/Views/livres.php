<?php


// use App\Repository\livresRepository;



// $repositoryLivres = new livresRepository;
// $repositoryLivres->chargementLivresBdd();

// $l1 = new ModelsLivre(1, "In My Head", 567, "in-my-head.png", "Image de couverture du livre in my head");
// $repositoryLivres->ajouterLivre($l1);
// $l2 = new ModelsLivre(2, "Le dev fou", 5676, "le_dev_fou.png", "Image de couverture du livre le dev fou");
// $repositoryLivres->ajouterLivre($l2);
// $l3 = new ModelsLivre(3, "Mon futur site web", 57, "mon-futur-site-web.png", "Image de couverture du livre mon futur site web");
// $repositoryLivres->ajouterLivre($l3);

// $livres = [$l1, $l2, $l3];


?>

<?php ob_start() ?>

<?php if(!$pasDeLivre) : ?>

<table class="table test-center">
    <tr class="table-dark">
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
        <th colspan="2">Actions</th>
    </tr>
    <?php
    // $livresTab = $repositoryLivres->getLivres();  
     foreach($livresTab as $livre) : ?> 
         <!-- : => signifie en attente de la fermeture  -->
    <tr>
        <td class="align-middle"><img src="images/<?= $livre->getUrlImage(); ?>" style="height: 60px;" ; alt="<?= $livre->getTextAlternatif(); ?>"></td>
        <td class="align-middle">
            <a href="<?= SITE_URL ?>livres/l/<?= $livre->getId() ?>"><?= $livre->getTitre() ?></a>
        </td>
        <td class="align-middle"><?= $livre->getNbreDePages(); ?> </td>
        <td class="align-middle">
            <a href="<?= SITE_URL ?>livres/m/<?= $livre->getId() ?>" class="btn btn-warning">Modifier</a>
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
<a href="<?= SITE_URL ?>livres/a" class="btn btn-success d-block w-100">Ajouter</a>
<?php else : ?>
    <div class="d-flex flex-column">
        <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
            <div class="card-header">Votre espace</div>
            <div class="card-body">
                <h4 class="card-title">Désolé</h4>
                <p class="card-text">Il semble que vous n'ayez pas encore uploadé de livre dans votre espace.</p>
                <p class="card-text">Pour y remédier, utilisez le bouton ci-dessous...</p>
            </div>
        </div>
        <a href="<?= SITE_URL ?>livres/a" class="btn btn-success d-block w-100">Ajouter</a>
    </div>
    <?php endif; ?>
<?php


$titre = "Livres";
$content = ob_get_clean();
require_once 'template.php';
