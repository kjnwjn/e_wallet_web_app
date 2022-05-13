<?php
require __DIR__ . '/vendor/autoload.php';
require './private/bridge.php';

use DevCoder\DotEnv;

try {
    (new DotEnv( './.env'))->load();
} catch(Exception){

}

session_start();

$myApp = new App();
