<?php
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Dashboard extends Controller
{
    protected $middleware;

    function __construct()
    {
        $this->middleware = new ApiMiddleware();
        $payload = $this->middleware->jwt_get_payload();
        !$payload ? header('Location: http://localhost/login') : null;
        if($payload && $payload->phoneNumber != 'admin') {   
            $this->view('Layout', array(
            'title' => '404 Not Found',
            'page' => '404'
            ));
            die();
        };
    }

    function default()
    {
        $this->view('LayoutAdmin', array(
            'title' => 'Dashboard',
            'page' => 'Dashboard'
        ));
    }
    function listAccount()
    {
        $this->view('LayoutAdmin', array(
            'title' => 'List Accounts',
            'page' => 'listAccount'
        ));
    }
    function listTransactions()
    {
        $this->view('LayoutAdmin', array(
            'title' => 'List Transactions',
            'page' => 'listTransaction'
        ));
    }
    function listAllTransaction()
    {
        $this->view('LayoutAdmin', array(
            'title' => 'List All Transactions',
            'page' => 'listAllTransaction'
        ));
    }
}
