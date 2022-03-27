<?php
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Dashboard extends Controller
{
    protected $middleware;

    function __construct(){
        // $this->middleware = new ApiMiddleware();
        // $payload = $this->middleware->jwt_get_payload();
        // !($payload && $payload->phoneNumber == 'admin') ? 
        // $this->middleware->json_send_response(404, array(
        //     'status' => false,
        //     "header_status_code" => 404,
        //     'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
        // )) : null;
    }

    function default()
    {
        $this->view('Layout1', array(
            'title' => 'Dashboard',
            'page' => 'Dashboard'
        ));
    }
    function listAccount(){
        $this->view('Layout1', array(
            'title' => 'List Accounts',
            'page' => 'listAccount'
        ));
    }
    function listTransactions(){
        $this->view('Layout1', array(
            'title' => 'List Transactions',
            'page' => 'listTransaction'
        ));
    }
}
