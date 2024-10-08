<?php

declare(strict_types=1);

//------------------------------------
function debug($var, $mode = 1)
{
    echo '<div style="background: blue; padding: 5px; float: right; clear: both; ">';
    $trace = debug_backtrace();
    $trace = array_shift($trace);
    echo "Debug demandé dans le fichier : $trace[file] à la ligne $trace[line].<hr />";
    if ($mode === 1) {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    } else {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
    echo '</div>';
}
//------------------------------------