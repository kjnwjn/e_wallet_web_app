<?php

require_once('./private/core/Controller.php');
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ServiceApi extends Controller
{
    protected $middleware;

    function __construct($route, $param)
    {
        $this->middleware = new ApiMiddleware();
        switch ($route) {
            case 'recharge':
                $this->middleware->request_method('post');
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                $this->recharge($payload);
                break;
            default:
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                ));
        }
    }

    // function query($param)
    // {
    //     (empty($param)) ?
    //         $this->middleware->json_send_response(200, array(
    //             'status' => false,
    //             'msg' => 'Card id is missing...'
    //         )) : null;

    //     $cardFound = $this->model('Card')->SELECT_ONE('card_id', $param);
    //     !$cardFound ? $this->middleware->json_send_response(200, array(
    //         'status' => false,
    //         'msg' => 'Failed to query! Card id is invalid!'
    //     )) : null;

    //     $this->middleware->json_send_response(200, array(
    //         'status' => true,
    //         'msg' => 'Successfully!',
    //         'data' => $cardFound
    //     ));
    // }
    function recharge($payload){
        $bodyDataErr = $this->utils()->validateBody(($_POST), array(
            'card_id' => array(
                'required' => true,
                'is_number' => true,
                'min' => 6,
                'max' => 7, 
            ),
            'expiredDay' => array(
                'required' => true,
            ),
            'cvv' => array(
                'required' => true,
                'min' => 3,
            ),
            'money' => array(
                'required' => true,
                'is_number' => true,
            )
        ));

        $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null;

        $cardInfor = $this->model('card')->SELECT_ONE('card_id',$_POST['card_id']);
        $userInfor = $this->model('account')->SELECT_ONE('email',$payload->email);
        !$cardInfor ? $this->middleware->error_handler(200, 'This card is not supported!') : null;
        
        $timestampCardData = date( "Y-m-d", strtotime($cardInfor['expiredDay']));
        $timestampCardValue = date( "Y-m-d", $_POST['expiredDay']);
        // var_dump(date("Y-m-d", $cardInfor['expiredDay']));
        echo date( "Y-m-d", strtotime($cardInfor['expiredDay']));
       echo (date( "Y-m-d", $_POST['expiredDay']));
       echo '<br>';
    //    echo (boolean)(date( "Y-m-d", $_POST['expiredDay']) == date( "Y-m-d", strtotime($cardInfor['expiredDay'])));
        // var_dump((int)((int)$_POST['expiredDay']/100000));
        echo !((boolean)($timestampCardData > $timestampCardValue));
        echo '</br>';

       
        !((boolean)($timestampCardData == $timestampCardValue)) ? $this->middleware->error_handler(200,"expiredDay is not correct!") : null;
        ((int)$cardInfor['cvv'] == $_POST['cvv']) ? $this->middleware->error_handler(200,"cvv is not correct!") : null;

        switch($_POST['card_id']){
            case 111111:
                $this->model('account')->UPDATE_ONE(array('email' =>$userInfor['email']),array('wallet'=>$_POST['money']+$userInfor['wallet']));             
                break;
            case 222222:
                $_POST['money'] > 1000000 ? $this->middleware->error_handler(200, 'This card only allows to loaded up to 1 million! Please try again') : null;
                $this->model('account')->UPDATE_ONE(array('email' =>$userInfor['email']),array('wallet'=>$_POST['money']+$userInfor['wallet']));             
                break;
            case 333333:
                $this->middleware->error_handler(200, 'This card out of money! Please try another card.');
                break;
            default:
                $this->ApiMiddleware->error_handler(200, 'This card is not supported!');

        }

        
    }
}
