<?php

declare(strict_types=1); // on déclare que les types des variables sont stricts

define('SITE_URL', str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]")); // on définit la constante SITE_URL
