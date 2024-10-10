<?php ob_start() ?>

<div style ="display: block">
<p><?= $message ?> &nbsp;</p>
<p> Contacter l'administrateur : <a href = "mailto:contact@monsite.fr" >ici</a></p>
</div>
<?php
$titre = "Erreur";
$content = ob_get_clean();
require_once 'template.php';
