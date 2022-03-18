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

            case 'transfer': 
                $this->middleware->request_method('post');
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                $this->transfer($payload);
                break;

            case 'withdraw': 
                $this->middleware->request_method('post');
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                $this->withdraw($payload);
                break;
            case 'confirm-OTP':
                $this->middleware->request_method('post');
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                $this->confirmOTP($payload);
                break;
            default:
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                ));
        }
    }

 
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
        
        $postExpiredDay = explode("/",$_POST['expiredDay']);
        $valExpiredDay = explode("/",$cardInfor['expiredDay']);
        ($postExpiredDay[0] == $valExpiredDay[0] && $postExpiredDay[1] == $valExpiredDay[1] && $postExpiredDay[2] == $valExpiredDay[2]) ?
        null : $this->middleware->error_handler(200,"expiredDay is not correct!");

        !((int)$cardInfor['cvv'] == $_POST['cvv']) ? $this->middleware->error_handler(200,"cvv is not correct!") : null;

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
       
        $inserted = $this->model('Transaction')->INSERT(array(
            'transaction_id' => $this->utils()->generateRandomInt(),
            'email' => $userInfor['email'],
            'type_transaction' => '1',
            'value_money' => $_POST['money'],
            'createdAt' => time(),
            'updatedAt' => time(),
            'action' => '1',
            'card_id' => $_POST['card_id'],
        ));  
        if ($inserted) {
            $this->middleware->json_send_response(200, array(
                'status' => true,
                'header_status_code' => 200,
                'msg' => 'Recharge successfully!',
            ));
        } else {
            $this->middleware->json_send_response(500, array(
                'status' => false,
                'header_status_code' => 500,
                'debug' => 'Service API function recharge',
                'msg' => 'An error occurred while processing, please try again!'
            ));
        }    

        
    }

    

    function transfer($payload){
        $bodyDataErr = $this->utils()->validateBody(($_POST), array(
            'phoneRecipient' => array(
                'required' => true,
                'tel' => true,
            ),
            'money' => array(
                'required' => true,
                'is_number' => true,
            ),
            'costBearer' => array(
                'required' => true,
            ),
            'note' => array(
                'required' => true,
            ),
        ));
        $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null;
        $recipient = $this->model('account')->SELECT_ONE('phoneNumber',$_POST['phoneRecipient']);
        $userInfor = $this->model('account')->SELECT_ONE('phoneNumber',$payload->phoneNumber);
        
        !($recipient ) 
        ? $this->middleware->error_handler(200, 'This user does not exist!') : null;
        !($recipient['phoneNumber'] != $userInfor['phoneNumber']) 
        ? $this->middleware->error_handler(200, 'The sender and recipient cannot be the same!') : null;
        if($_POST['costBearer'] == 'sender'){
            $totalForUser = ($_POST['money'] + $_POST['money']*0.05);
            $totalForRecipient = $_POST['money'];
        }else{
            $totalForUser = $_POST['money'] ;
            $totalForRecipient = ($_POST['money'] - $_POST['money']*0.05);
        }
        ($userInfor['wallet'] < $totalForUser) 
        ? $this->middleware->error_handler(200, 'Your account does not enough money to make this transaction!') 
        : null;
        $transaction_id = $this->utils()->generateRandomInt();
        $costBearer = $_POST['costBearer'];
        $email = $userInfor['email'];
        $phoneRecipient = $_POST['phoneRecipient'];
        $type_transaction = '2';
        $value_money = $_POST['money'];
        $description = $_POST['note'];
        $OTP = $this->utils()->generateRandomInt();
        $action = ($_POST['money'] > 5000000) ? null : 1;
        $sendMailStatus = $this->utils()->sendMail(array(
            "email" => $userInfor['email'],
            'title' => 'OTP code for transfer transaction',
            'content' => '
                <body>
                    <p>Here is your OTP code to confirm the transaction (money transfer) from your card</p>
                    <p>Please do not send this OTP code for anyone</p>
                    <p><strong>OTP code: ' . $OTP . '</strong></p>
                </body>
            ',
        ));
        $time_expire = time() + 60;
        
        $_SESSION['transactionPrepare'] = array(
            'transaction_id' => $transaction_id,
            'email' => $email,
            'phoneRecipient'  => $phoneRecipient,
            'type_transaction'  => $type_transaction,
            'value_money'  => $value_money,
            'description'  => $description,
            'costBearer' => $costBearer,
            'OTP' => $OTP, 
            'action' => $action,
            'time_expire' => $time_expire,
            'totalForUser' => $totalForUser,
            'totalForRecipient' => $totalForRecipient,
        ) ;
        if($_SESSION['transactionPrepare']){
            if($sendMailStatus){
                $this->middleware->json_send_response(200, array(
                    'status' => true,
                    'header_status_code' => 200,
                    'msg' => 'We have sent an email that contain your OTP to complete this transaction, check it now!',
                    'redirect' => getenv('BASE_URL') . 'service/confirm-OTP/'
                )) ;
            }else{
                $this->middleware->error_handler(500,[
                    'debug' => 'Service Api function transfer',
                    'msg' => 'An error occurred while processing, please try again!'
                ]);
            }
        }else{
            $this->middleware->error_handler(500,[
            'debug' => 'Service Api function transfer',
            'msg' => 'An error occurred while processing, please try again!'
            ]);
        };
        
    }

    function withdraw($payload){
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
            ),
            'description' => array(
                'required' => true,
            ),
        ));
        $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null;

        $cardInfor = $this->model('card')->SELECT_ONE('card_id',$_POST['card_id']);
        !$cardInfor ? $this->middleware->error_handler(200, 'Card information is invalid') : null;
        !($cardInfor['card_id'] == '111111') ? $this->middleware->error_handler(200, 'This card is not supported for withdrawal function') : null;
        
        $postExpiredDay = explode("/",$_POST['expiredDay']);
        $valExpiredDay = explode("/",$cardInfor['expiredDay']);
        ($postExpiredDay[0] == $valExpiredDay[0] && $postExpiredDay[1] == $valExpiredDay[1] && $postExpiredDay[2] == $valExpiredDay[2]) ?
        null : $this->middleware->error_handler(200,"expiredDay is not correct!");

        !((int)$cardInfor['cvv'] == $_POST['cvv']) ? $this->middleware->error_handler(200,"cvv is not correct!") : null;
        !($_POST['money'] % 50000 == 0) ? $this->middleware->error_handler(200,"Money value must be a multiple of 50000!") : null;
        $indayCount = 0;
        $userInfor = $this->model('account')->SELECT_ONE('email',$payload->email);

        $transactionHistory = $this->model('transaction')->SELECT('email',$payload->email);
        foreach ($transactionHistory as $key => $value) {
            $validDate = date('Y-m-d',$value['createdAt']) == date('Y-m-d',time());
            if ($value['type_transaction'] == 3 && $validDate){
                $indayCount += 1;
            }
        }
        
        if ($indayCount > 2) {
            $this->middleware->error_handler(200,"The number of transaction must be less than 2 time/day"); 
        } else {
            $value_money = $_POST['money'] + $_POST['money']* 0.05;
            ($userInfor['wallet']< $value_money) 
            ? $this->middleware->error_handler(200,'Your account does not enough money to make this transaction!') 
            : null;
            $transaction_id = $this->utils()->generateRandomInt();
            $email = $userInfor['email'];
            $type_transaction = 3;
            $description = $_POST['description'];
            $action = ($_POST['money'] > 5000000) ? null : 1;
            $inserted = $this->model('Transaction')->INSERT(array(
                'transaction_id' => $transaction_id,
                'email' =>  $email,
                'type_transaction' => $type_transaction,
                'value_money' => $_POST['money'],
                'description'=> $description,
                'createdAt' => time(),
                'updatedAt' => time(),
                'action' => $action,
            )); 
            if($inserted && $action){
                $this->model('account')->UPDATE_ONE(array('email' =>$email),array('wallet'=>$userInfor['wallet'] - $value_money))?             
                $this->middleware->json_send_response(200, array(
                    'status' => true,
                    'header_status_code' => 200,
                    'msg' => 'Withdraw money transaction successfully!',
                    'redirect' => getenv('BASE_URL')  . 'translationHistory'. '/' . 'id/'. $transaction_id ,
                )): $this->middleware->json_send_response(500, array(
                    'status' => false,
                    'header_status_code' => 500,
                    'debug' => 'Service API function withdraw',
                    'msg' => 'An error occurred while processing, please try again!'
                ));
            }else if(($inserted && !$action)){
                $this->middleware->json_send_response(200, array(
                    'status' => true,
                    'header_status_code' => 200,
                    'msg' => 'Your transaction is pendding!',
                    'redirect' => getenv('BASE_URL')  . 'translationHistory'. '/' . 'id/'. $transaction_id ,
                ));
            }else{
                $this->middleware->json_send_response(500, array(
                    'status' => false,
                    'header_status_code' => 500,
                    'debug' => 'Service API function withdraw',
                    'msg' => 'An error occurred while processing, please try again!'
                ));

            }
        }
      
    }
    
    // Người dùng post lên 1 OTP được gửi thông qua email, mission :Check otp
    function confirmOTP($payload){
        // unset($_SESSION['transactionPrepare']);
        if(isset($_SESSION) && isset($_SESSION['transactionPrepare'])){
            $bodyDataErr = $this->utils()->validateBody(($_POST), array(
                'otpValue' => array(
                    'required' => true,
                ),
            ));
            $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null ;
            
            $transaction_id = $_SESSION['transactionPrepare']['transaction_id'];
            $email = $_SESSION['transactionPrepare']['email'];
            $phoneRecipient = $_SESSION['transactionPrepare']['phoneRecipient'];
            $type_transaction = $_SESSION['transactionPrepare']['type_transaction'];
            $value_money = $_SESSION['transactionPrepare']['value_money'];
            $description = $_SESSION['transactionPrepare']['description'];
            $costBearer = $_SESSION['transactionPrepare']['costBearer'];
            $OTP = $_SESSION['transactionPrepare']['OTP'];
            $action = $_SESSION['transactionPrepare']['action'];
            $time_expire = $_SESSION['transactionPrepare']['time_expire'];
            $totalForUser =  $_SESSION['transactionPrepare']['totalForUser'];
            $totalForRecipient =  $_SESSION['transactionPrepare']['totalForUser'];
            $recipient = $this->model('account')->SELECT_ONE('phoneNumber',$phoneRecipient);
            $userInfor = $this->model('account')->SELECT_ONE('phoneNumber',$payload->phoneNumber);
        
        
            if(isset($time_expire) && time() > $time_expire) {
                unset($_SESSION['transactionPrepare']);
                $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Expired OTP',
                    'redirect' => getenv('BASE_URL') . 'transfer'
                )) ;
            }else{
                !($_POST['otpValue'] ==  $OTP) 
                ? $this->middleware->error_handler(200,'Invalid OTP! Please try again.') 
                : null;
                $inserted = $this->model('Transaction')->INSERT(array(
                    'transaction_id' => $transaction_id,
                    'email' =>  $email,
                    'phoneRecipient' => $phoneRecipient,
                    'type_transaction' => $type_transaction,
                    'value_money' => $value_money,
                    'description'=> $description,
                    'costBearer' => $costBearer,
                    'createdAt' => time(),
                    'updatedAt' => time(),
                    'action' => $action,
                    
                )); 
                if ($inserted) {
                    if(!$action){
                        unset($_SESSION['transactionPrepare']);
                        $this->middleware->json_send_response(200, array(
                            'status' => true,
                            'header_status_code' => 200,
                            'msg' => 'Your transaction is pendding! ',
                            'redirect' => getenv('BASE_URL')  . 'translationHistory'. '/' . 'id/'. $transaction_id ,
                        ));
                    }else{
                        $isUpdateWalletUser = $this->model('account')->UPDATE_ONE(array('email' =>$email),array('wallet'=>$userInfor['wallet'] - $totalForUser));             
                        $isUpdateWalletUser = $this->model('account')->UPDATE_ONE(array('phoneNumber' =>$phoneRecipient),array('wallet'=>$recipient['wallet'] + $totalForRecipient));   
                        unset($_SESSION['transactionPrepare']);
                        if($isUpdateWalletUser && $isUpdateWalletUser) {
                            // $sendMailStatus = $this->utils()->sendMail(array(
                            //     "email" => $userInfor['email'],
                            //     'title' => 'OTP code for transfer transaction',
                            //     'content' => '
                            //         <body>
                            //             <p>Here is your OTP code to confirm the transaction (money transfer) from your card</p>
                            //             <p>Please do not send this OTP code for anyone</p>
                            //             <p><strong>OTP code: ' . $OTP . '</strong></p>
                            //         </body>
                            //     ',
                            // ));
                             $this->middleware->json_send_response(200, array(
                                'status' => true,
                                'header_status_code' => 200,
                                'msg' => 'Transfer money successfully!',
                                'redirect' => getenv('BASE_URL')  . 'translationHistory'. '/' . 'id/'. $transaction_id ,
                            ));
                        }else{
                            $this->middleware->json_send_response(500, array(
                                'status' => false,
                                'header_status_code' => 500,
                                'debug' => 'Service API function confirmOTP',
                                'msg' => 'An error occurred while processing, please try again!'
                            ));
                        }
                    }
                } else {
                    $this->middleware->json_send_response(500, array(
                        'status' => false,
                        'header_status_code' => 500,
                        'debug' => 'Service API function confirmOTP',
                        'msg' => 'An error occurred while processing, please try again!'
                    ));
                }    
            }
        }else{
            $this->middleware->json_send_response(401, array(
                'status' => false,
                "header_status_code" => 401,
                'msg' => 'Unauthorized!'
            ));
        }
    }
    
}
