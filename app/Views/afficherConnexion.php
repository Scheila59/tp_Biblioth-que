<?php ob_start(); ?>

<?php require '../app/Views/showErreurs.php'; ?>
<!-- <?php debug($_POST); ?> -->

<!-- <form action="" method="POST"> -->

<form method="POST" action="<?= SITE_URL ?>login/v">
  <fieldset>
    <div>
      <label for="email" class="form-label mt-4">Adresse email : </label>
      <input type="email" autofocus class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Entrez votre adresse email">
      <small id="emailHelp" class="form-text text-muted"></small>
    </div>
    <div>
      <label for="password" class="form-label mt-4">Mot de passe</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Entrer votre mot de passe" autocomplete="off">
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
  </fieldset>
</form>

<?php
$titre = 'Connexion';
$content = ob_get_clean();
require_once 'template.php';





