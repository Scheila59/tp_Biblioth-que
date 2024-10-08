<?php

declare(strict_types=1);

require __DIR__ . '/app/lib/init.php';
require __DIR__ . '/app/lib/functions.php';
// debug(dirname(__DIR__)); 
?>

<?php
try {
    // debug($_GET, $mode = 0);
    if (empty($_GET['page'])) {
        require 'app/Views/accueil.php';
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        switch ($url[0]) {
            case 'livres':
                require 'app/Views/livres.php'; // appeler controller
                break;
        }
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
