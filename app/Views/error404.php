<?php ob_start() ?>

<div style ="display: block">
<p>Le contenu n'est plus disponible</p>
<p>Contacter l'administrateur : <a href = "mailto:contact@monsite.fr" >ici</a></p>
</div>
<?php
$titre = "Accueil";
$content = ob_get_clean();
require_once 'template.php';
