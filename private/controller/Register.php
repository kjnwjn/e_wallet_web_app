<?php
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');
class Register extends Controller
{
    function __construct()
    {
        $this->middleware = new ApiMiddleware();
        $payload = $this->middleware->jwt_get_payload();
        if($payload) {   
            $this->view('Layout', array(
            'title' => '404 Not Found',
            'page' => '404'
            ));
            die();
        };
    }
    function default()
    {
        $this->view('layoutValidate', array(
            'title' => 'register',
            'page' => 'register'
        ));
    }
}
