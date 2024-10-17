<?php ob_start(); ?>

<h2>Inscription</h2>

<?php
if (isset($_SESSION['erreurs'])) {
    foreach ($_SESSION['erreurs'] as $champ => $erreurs) {
        if (is_array($erreurs)) {
            foreach ($erreurs as $erreur) {
                echo "<div class='alert alert-danger'>" . $erreur . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>" . $erreurs . "</div>";
        }
    }
    unset($_SESSION['erreurs']);
}
?>

<form action="<?= SITE_URL ?>inscription/submit" method="post" onsubmit="return validateForm()">
    <div class="mb-3">
        <label for="identifiant" class="form-label">Identifiant</label>
        <input type="text" class="form-control" id="identifiant" name="identifiant" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>
<script>
function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    if (password != confirmPassword) {
        alert("Les mots de passe ne correspondent pas.");
        return false;
    }
    return true;
}
</script>

<?php 
$titre = "inscription";
$content = ob_get_clean(); 
require_once 'template.php';

