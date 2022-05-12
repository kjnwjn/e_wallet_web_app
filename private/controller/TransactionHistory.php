<?php
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class TransactionHistory extends Controller
{
    function __construct(){
        $this->middleware = new ApiMiddleware();
        $payload = $this->middleware->jwt_get_payload();
        if(!($payload)) {
            header('Location: '.getenv('BASE_URL').'login');
            die();
        } 
        
        if(!($payload->role == 'actived')) {   
            $this->view('LayoutError', array(
                'title' => 'Forbidden',
                'error_code' => '403',
                'error_Content' => 'FORBIDDEN. YOU DO NOT HAVE PERMISSION TO ACCESS THIS PAGE.'
            ));
            die();
        };
    }
    function default()
    {
        $this->view('Layout', array(
            'title' => 'TransactionHistory',
            'page' => 'TransactionHistory'
        ));
    }
}