<?php
function dd($var, $die = true) {
    echo '<pre>' . print_r($var, true) . '</pre>';
    if ($die) die;
}

