<?php

declare(strict_types=1);

define('SITE_URL', str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

//var_dump(SITE_URL);