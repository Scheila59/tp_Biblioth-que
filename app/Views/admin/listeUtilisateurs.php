<?php ob_start(); ?>

<h2>Liste des Utilisateurs</h2>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Identifiant</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($utilisateurs as $utilisateur): ?>
        <tr>
            <td><?= htmlspecialchars($utilisateur['id_utilisateur']) ?></td>
            <td><?= htmlspecialchars($utilisateur['identifiant']) ?></td>
            <td><?= htmlspecialchars($utilisateur['email']) ?></td>
            <td><?= htmlspecialchars($utilisateur['role']) ?></td>
            <td>
                <a href="<?= SITE_URL ?>admin/utilisateurs/modifier/<?= $utilisateur['id_utilisateur'] ?>" class="btn btn-primary">Modifier</a>
                <a href="<?= SITE_URL ?>admin/utilisateurs/supprimer/<?= $utilisateur['id_utilisateur'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$titre = "Utilisateurs";
$content = ob_get_clean();
require_once '../app/Views/template.php';
?>
