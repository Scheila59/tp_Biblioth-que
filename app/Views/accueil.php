<?php ob_start() ?>

Mon contenu

<?php
$titre = "Accueil";
$content = ob_get_clean();
require_once 'template.php';
