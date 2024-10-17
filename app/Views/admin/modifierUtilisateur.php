<?php ob_start(); ?>

<h2>Modifier l'Utilisateur</h2>

<form action="<?= SITE_URL ?>admin/utilisateurs/mettre-a-jour" method="post">
    <input type="hidden" name="id" value="<?= $utilisateur['id_utilisateur'] ?>">
    
    <div class="mb-3">
        <label for="identifiant" class="form-label">Identifiant</label>
        <input type="text" class="form-control" id="identifiant" name="identifiant" value="<?= htmlspecialchars($utilisateur['identifiant']) ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($utilisateur['email']) ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="role" class="form-label">Rôle</label>
        <select class="form-control" id="role" name="role" required>
            <option value="ROLE_USER" <?= $utilisateur['role'] === 'ROLE_USER' ? 'selected' : '' ?>>Utilisateur</option>
            <option value="ROLE_ADMIN" <?= $utilisateur['role'] === 'ROLE_ADMIN' ? 'selected' : '' ?>>Administrateur</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>

<?php
$titre = "Modifier Utilisateur";
$content = ob_get_clean();
require_once '../app/Views/template.php';
?>
