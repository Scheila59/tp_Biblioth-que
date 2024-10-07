<?php

//------------------------------------
function debug($var, $mode = 1) 
{
        echo '<div style="background: pink; padding: 5px; float: right; clear: both; border-radius: 25px; border: solid 2px black">';
        $trace = debug_backtrace(); 
        $trace = array_shift($trace);
        echo "Debug demand� dans le fichier : $trace[file] � la ligne $trace[line].<hr />";
        if($mode === 1)
        {
            echo "<pre>"; print_r($var); echo "</pre>";
        }
        else
        {
            echo "<pre>"; var_dump($var); echo "</pre>";
        }
    echo '</div>';
}
//------------------------------------