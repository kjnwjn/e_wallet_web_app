<?php
require_once('./private/apis/Account.api.php');

class Api extends Controller
{
    function __construct()
    {
        header('Content-Type: application/json');
    }

    function default()
    {
        $this->error_handler(404, 'This endpoint cannot be found, please contact adminstrator for more information!');
    }

    function account($route = "", $param = "")
    {
        new AccountApi($route, $param);
    }
}
