<?php

declare(strict_types=1);

//------------------------------------
function debug($var, $mode = 1)
{
    echo '<div style="background: #acacf1; padding: 5px; margin: 10px; max-width: 100%; overflow-x: auto; word-wrap: break-word; border-radius: 255px 25px 225px 25px / 25px 225px 25px 255px; padding: 20px;">';
    $trace = debug_backtrace();
    $trace = array_shift($trace);
    echo "<p style='font-size: 14px; margin: 0 0 10px;'>Debug demandé dans le fichier : " . htmlspecialchars($trace['file']) . " à la ligne " . $trace['line'] . ".</p><hr />";
    echo "<div style='font-size: 12px;'>";
    if ($mode === 1) {
        echo "<pre style='white-space: pre-wrap;'>";
        print_r($var);
        echo "</pre>";
    } else {
        echo "<pre style='white-space: pre-wrap;'>";
        var_dump($var);
        echo "</pre>";
    }
    echo "</div></div>";
}
//------------------------------------
