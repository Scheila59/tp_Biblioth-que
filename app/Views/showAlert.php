<?php if (array_key_exists('alert', $_SESSION)) : ?>
<div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
    <?= $_SESSION['alert']['message'] ?>
</div>
    <?php
    unset($_SESSION['alert']);
endif;
?>