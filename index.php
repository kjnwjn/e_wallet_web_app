<?php
session_start();
require_once('./private/bridge.php');
$_SERVER['HTTP_HOST'] = 'http://localhost/live/';
$myApp = new App();
