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
        switch ($route) {
            case 'list-account':
                $this->middleware->request_method('get');
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                !($payload && $payload->phoneNumber == 'admin') ? 
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                )) : null;
                $this->listAccount($param);
                break;
            case 'list-transaction-confirm':
                $this->middleware->request_method('get');
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                !($payload && $payload->phoneNumber == 'admin') ? 
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                )) : null;
                $this->listTransConfirm($param);
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
                print_r($accountPending);
                break;
            case 'actived' :
                $accountActived =$this->model('Account')->SELECT('role', 'actived');
                print_r($accountActived);
                break;
            case 'disabled':
                $accountDisabled =$this->model('Account')->SELECT('role', 'disabled');
                print_r($accountDisabled);
                break;
            case 'blocked':
                $accountBlocked =$this->model('Account')->SELECT('role', 'blocked');
                print_r($accountBlocked);
                break;
            case '':
                $accountAll = $this->model('Account')->SELECT_ALL();
                foreach($accountAll as $key => $value){
                    if($value['email'] == 'admin@gmail.com'){
                       unset($accountAll[$key]);
                    }
                }
                print_r($accountAll);
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
        $transNeedConfirm = !$this->model('transaction')->SELECT('action', 0) 
        ?  
        $this->middleware->json_send_response(500, array(
            'status' => false,
            'header_status_code' => 500,
            'debug' => 'AdminAPI API function listTransConfirm(SELECT)',
            'msg' => 'An error occurred while processing, please try again!'
        )) : $this->model('transaction')->SELECT('action', 0);
        // print_r($transNeedConfirm);

        switch($param){
            case 'withdraw' : 
                $transWithdraw = [];
                foreach($transNeedConfirm as $key => $value){
                    if($value['type_transaction'] == '3'){
                        array_push($transWithdraw,$transNeedConfirm[$key]);
                    }
                }
                break;
            case 'transfer' :
                $transTransfer = [];
                foreach($transNeedConfirm as $key => $value){
                    if($value['type_transaction'] == '2'){
                        array_push($transTransfer,$transNeedConfirm[$key]);
                    }
                }
                print_r($transTransfer);
                break;
            case '':
                print_r($transNeedConfirm);
                break;
            default :
            $this->middleware->json_send_response(404, array(
                'status' => false,
                "header_status_code" => 404,
                'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
            ));

        }
    }
}