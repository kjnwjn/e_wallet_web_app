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
        !($payload && $payload->phoneNumber == 'admin') ?
            header('Location: http://localhost/login') : null;
    }

    function default()
    {
        $this->view('Layout1', array(
            'title' => 'Dashboard',
            'page' => 'Dashboard'
        ));
    }
    function listAccount()
    {
        $this->view('Layout1', array(
            'title' => 'List Accounts',
            'page' => 'listAccount'
        ));
    }
    function listTransactions()
    {
        $this->view('Layout1', array(
            'title' => 'List Transactions',
            'page' => 'listTransaction'
        ));
    }
}
