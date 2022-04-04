<?php
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class SetupPassword extends Controller
{
    // function __construct()
    // {
    //     $this->middleware = new ApiMiddleware();
    //     $payload = $this->middleware->jwt_get_payload();
    //     $userInfor = $this->model('Account')->SELECT_ONE('phoneNumber',$payload->phoneNumber);
      
    //     if($payload || $userInfor['initialPassword'] == null) {   
    //         $this->view('Layout', array(
    //         'title' => '404 Not Found',
    //         'page' => '404'
    //         ));
    //         die();
    //     };
    // }
    function default()
    {
        $this->view('layoutValidate', array(
            'title' => 'Setup Password',
            'page' => 'setupPassword'
        ));
    }
}
