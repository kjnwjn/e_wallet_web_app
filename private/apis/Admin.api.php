<?php
require_once('./private/core/Controller.php');
require_once('./private/core/jwt/vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class AdminApi extends Controller
{
    protected $middleware;

    function __construct($route, $param)
    {
        $this->middleware = new ApiMiddleware();
        // $this->middleware->authentication();
        // $payload = $this->middleware->jwt_get_payload();
        // !($payload) ? 
        // $this->middleware->json_send_response(200, array(
        //     'status' => false,
        //     "header_status_code" => 200,
        //     'msg' => 'Please login first!',
        //     'redirect' => getenv('BASE_URL') . 'login',
        // )) : null;
        // !($payload->phoneNumber == 'admin')? 
        // $this->middleware->json_send_response(404, array(
        //     'status' => false,
        //     "header_status_code" => 404,
        //     'msg' => 'This account does not have permission!!'
        // )) : null;
        switch ($route) {
            case 'list-account':
                $this->middleware->request_method('get');
                $this->listAccount($param);
                break;
            case 'list-transaction-confirm':
                $this->middleware->request_method('get');
                $this->listTransConfirm($param);
                break;
            case 'user-details':
                $this->middleware->request_method('get');
                $this->userDetails($param);
                break;
            default:
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                ));
        }
    }

    function listAccount($param){
        switch($param){
            case 'pending' : 
                $accountPending =$this->model('Account')->SELECT('role', 'pending');
                !$accountPending ?   $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any account pending!'
                )): $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $accountPending,
                ));
                break;
            case 'actived' :
                $accountActived =$this->model('Account')->SELECT('role', 'actived');
                !$accountActived ?   $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any account actived!',
                )): $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $accountActived,
                ));
                break;
            case 'disabled':
                $accountDisabled =$this->model('Account')->SELECT('role', 'disabled');
                !$accountDisabled ?   $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any account disabled!',
                )): $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $accountDisabled,
                ));
                break;
            case 'blocked':
                $accountBlocked =$this->model('Account')->SELECT('deleted', '1');
                !$accountBlocked ?   $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any account blocked!',
                )): $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $accountBlocked,
                ));
                break;
            case '':
                $accountAll = $this->model('Account')->SELECT_ALL();
                !$accountAll ?  $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any account!',
                )): $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $accountAll,
                ));
                break;
            default :
            $this->middleware->json_send_response(404, array(
                'status' => false,
                "header_status_code" => 404,
                'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
            ));

        }
    }

    function listTransConfirm($param){
       
        $transNeedConfirm = $this->model('transaction')->SELECT('action', 0) ;
        switch($param){

            case 'withdraw' : 
                $transWithdraw = [];
                foreach($transNeedConfirm as $key => $value){
                    if($value['type_transaction'] == '3'){
                        array_push($transWithdraw,$transNeedConfirm[$key]);
                    }
                }
                !$transWithdraw ? $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any transaction to confirm !',
                )): $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $transWithdraw,
                ));
                print_r($transWithdraw);
                break;
            case 'transfer' :
                $transTransfer = [];
                foreach($transNeedConfirm as $key => $value){
                    if($value['type_transaction'] == '2'){
                        array_push($transTransfer,$transNeedConfirm[$key]);
                    }
                }
                !$transTransfer ? $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any transaction to confirm !',
                )): $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $transTransfer,
                ));
                break;
            case '':
                !$transNeedConfirm ? $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any transaction to confirm !',
                )): $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $transNeedConfirm,
                ));
                break;
            default :
            $this->middleware->json_send_response(404, array(
                'status' => false,
                "header_status_code" => 404,
                'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
            ));

        }
    }

    function userDetails($phoneNumber){
        !$phoneNumber ? $this->middleware->json_send_response(404, array(
            'status' => false,
            "header_status_code" => 404,
            'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
        )) : null;

        $userInfor = $this->model('account')->SELECT_ONE('phoneNumber',$phoneNumber);
        !$userInfor ? $this->middleware->json_send_response(200, 'This account does not exist') : 
        $this->middleware->json_send_response(200, array(
            'status' => true,
            "header_status_code" => 200,
            'msg' => 'Load List User successfully!',
            'data' => $userInfor,
        ));
        

    }
    function confirmTransaction(){
        if(isset($_POST['btn'])){

        }
    }
}