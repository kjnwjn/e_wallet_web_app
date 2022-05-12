<?php

session_start();
set_include_path('./private/core/DevCode.php');
set_include_path('./private/Bridge.php');

use DevCoder\DotEnv;

(new DotEnv(__DIR__ . '/.env'))->load();

$myApp = new App();
