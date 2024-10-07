<?php
require 'Models/livres/Livre.php';

$l1 = new Livre(1, "In My Head", 345, "/public/images/in-my-head.png", "Image de couverture du livre in my head");
$l2 = new Livre(2, "le dev fou", 9999, "/public/images/le_dev_fou.png", "Image de couverture du livre le dev fou");
$l3 = new Livre(3, "Mon futur site Web", 786, "/public/images/mon-futur-site-web.png", "Image de couverture du livre Mon futur site Web");

$livres = [$l1, $l2, $l3]
?>

<?php ob_start() ?>

<table class ="table test-center">
    <tr class="table-secondary">
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
        <th colspan="2">Actions</th>
    </tr>
    <tr>
        <td class="align-middle"><img src="public/images/in-my-head.png" alt="livre" style="height: 60px;"></td>
        <td class="align-middle">In my Head</td>
        <td class="align-middle">345</td>
        <td class="align-middle"><a href="#" class="btn btn-info">Modifier</a></td>
        <td class="align-middle"><a href="#" class="btn btn-success">Supprimer</a></td>
    </tr>
    <tr>
        <td class="align-middle"><img src="public/images/le_dev_fou.png" alt="livre" style="height: 60px;"></td>
        <td class="align-middle">Le dev fou</td>
        <td class="align-middle">9999</td>
        <td class="align-middle"><a href="#" class="btn btn-info">Modifier</a></td>
        <td class="align-middle"><a href="#" class="btn btn-success">Supprimer</a></td>
    </tr>
    <tr>
        <td class="align-middle"><img src="public/images/mon-futur-site-web.png" alt="livre" style="height: 60px;"></td>
        <td class="align-middle">Mon futur site Web</td>
        <td class="align-middle">786</td>
        <td class="align-middle"><a href="#" class="btn btn-info">Modifier</a></td>
        <td class="align-middle"><a href="#" class="btn btn-success">Supprimer</a></td>
    </tr>
</table>
<a href="#" class="btn btn-danger d-block w-100">Ajouter</a>

<?php
$titre = "livres";
$content = ob_get_clean();
require_once 'template.php';