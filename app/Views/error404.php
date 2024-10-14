<?php ob_start() ?>

<div style ="display: block"> <!-- afficher le message d'erreur -->
<p><?= $message ?> &nbsp;</p> <!-- afficher le message d'erreur -->
<p> Contacter l'administrateur : <a href = "mailto:contact@monsite.fr" >ici</a></p> <!-- afficher le lien pour contacter l'administrateur -->
</div>
<?php
$titre = "Erreur"; // définir le titre de la page
$content = ob_get_clean(); // nettoyer le tampon de sortie
require_once 'template.php'; // inclure le template
