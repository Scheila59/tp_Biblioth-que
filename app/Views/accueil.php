<?php ob_start() ?>

<div class="d-flex flex-wrap justify-content-center"> 
<?php
foreach ($livresAll as $livre) : ?>
    <div class="card m-3 mx-auto w-25" style="min-width: 350px;">
        <h3 class="card-header"><?= $livre->getTitre() ?></h3>
        <img class="mx-auto mt-4" style="height: auto; width: 150px;" src="<?= SITE_URL ?>images/<?= $livre->getUrlImage(); ?>">
        <div class=" card-body">
        <div class="card-body">
                <p>Uploader : <?= $livre->getUploader(); ?></p>
            </div>
            <div class="card-body">
                <a href="<?= SITE_URL ?>livres/l/<?= $livre->getId(); ?>">
                    En savoir plus ...
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php
$titre = "Accueil";
$content = ob_get_clean();
require_once 'template.php';
