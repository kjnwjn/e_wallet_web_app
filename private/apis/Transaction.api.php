<?php
require_once('./private/core/Controller.php');
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class transactionApi extends Controller{
    protected $middleware;

    function __construct($route, $param)
    {
        $this->middleware = new ApiMiddleware();
        $this->middleware->request_method('get');
        $this->middleware->authentication();
        $payload = $this->middleware->jwt_get_payload();
        switch ($route) {
            case 'histories':
                $this->histories($payload);
                break;
            case 'transaction__details': 
                break;
            case 'confirm-OTP':
                break;
            default:
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                ));
        }

    }

    function histories($payload){

    }
}