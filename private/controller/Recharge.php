<?php
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Recharge extends Controller
{
    function __construct(){
        $this->middleware = new ApiMiddleware();
        $payload = $this->middleware->jwt_get_payload();
        if(!($payload)) {
            header('Location: '.getenv('BASE_URL').'login');
            die();
        } 
        !($payload->role == 'actived')? 
        $this->middleware->json_send_response(404, array(
            'status' => false,
            "header_status_code" => 404,
            'msg' => 'This account does not have permission!!'
        )) : null;
    }
    function default()
    {
        $this->view('Layout', array(
            'title' => 'Recharge',
            'page' => 'recharge'
        ));
    }
}
