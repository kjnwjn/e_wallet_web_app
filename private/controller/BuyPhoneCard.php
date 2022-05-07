<?php
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class BuyPhoneCard extends Controller
{
    function __construct(){
        $this->middleware = new ApiMiddleware();
        $this->middleware->authentication();
        $payload = $this->middleware->jwt_get_payload();
        !($payload) ? 
        $this->middleware->json_send_response(200, array(
            'status' => false,
            "header_status_code" => 200,
            'msg' => 'Please login first!',
            'redirect' => getenv('BASE_URL') . 'login',
        )) : null;
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
            'title' => 'BuyPhoneCard',
            'page' => 'buyPhoneCard'
        ));
    }
}
