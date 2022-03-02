<?php
class Api extends Controller
{

    function __construct()
    {
        header('Content-Type: application/json');
    }

    function default()
    {
        // khởi tạo đối tượng tèo sử dụng được những hàm từ đối tượng sinhvienmodel

        // khời tạo đối tượng sử dụng view của home load ra data là danh sách student 
        echo json_encode([
            'status' => false,
            'err' => 404,
            'msg' => 'This endpoint cannot be found, please contact adminstrator for more information.',
        ]);
    }

    function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => false,
                'msg' => 'Method not allowed!'
            ]);
            exit();
        } else {
            if (!isset($_POST['username']) || empty(trim($_POST['username']))) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Username is required!'
                ]);
            } else if (!isset($_POST['password']) || empty(trim($_POST['password']))) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Password is required!'
                ]);
            } else {
                $password = trim($_POST['password']);
                $username = trim($_POST['username']);
                if ($this->model('Account')->is_phone_number_exit($username)) {
                    if ($this->model('Account')->login($username, $password) && $this->model('Account')->checkWrongPassword($username)) {
                        $this->model('Account')->updateWrongPassword(3, $username);
                        // $this->model('Account')->updateAbnormal(1, $username);
                        $_SESSION['username'] = $username;
                        if (!$this->model('Account')->checkActive($username)) {
                            echo json_encode([
                                'status' => true,
                                'msg' => 'Please change your password!',
                                'redirect' => '../changePassword'
                            ]);
                        } else {
                            echo json_encode([
                                'status' => true,
                                'msg' => 'Login successfully!',
                                'redirect' => '../'
                            ]);
                        }
                    } else {

                        // nếu sai mật khẩu quá 3 lần
                        $wrongpassword = $this->model('Account')->checkWrongPassword($username);
                        echo $wrongpassword;

                        if (!$wrongpassword) {
                            $_SESSION['last_tmp_time'] = time();
                            $abnormal = $this->model('Account')->checkAbnormal($username);
                            if (!$abnormal) {

                                echo json_encode([
                                    'status' => false,
                                    'msg' => 'Tài khoản đã bị khóa do nhập sai mật khẩu nhiều lần, vui lòng liên hệ quản trị viên để được hỗ trợ.',
                                    'abnormal' => 0
                                ]);
                            } else {
                                if ($this->model('Account')->updateAbnormal(0, $username)) {
                                    if (date('i', time() - $_SESSION['last_time']) === '60') {
                                        $this->model('Account')->updateWrongPassword(3, $username);
                                    } else {
                                        echo json_encode([
                                            'status' => false,
                                            'msg' => 'Tài khoản hiện đang bị tạm khóa, vui lòng thử lại sau 1 phút.',
                                            'abnormal' => 1
                                        ]);
                                    }
                                }
                            }
                        } else {
                            if ($wrongpassword == 1) {
                                $_SESSION['last_time'] = time();
                                echo $_SESSION['last_time'];
                            }
                            if ($this->model('Account')->updateWrongPassword($wrongpassword - 1, $username)) {

                                echo json_encode([
                                    'status' => false,
                                    'msg' => 'Invalid Password!'

                                ]);
                            }
                        }
                    }
                } else {
                    echo json_encode([
                        'status' => false,
                        'msg' => 'Account is not exits!'
                    ]);
                }
            }
        }
    }

    function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => false,
                'msg' => 'Method not allowed!'
            ]);
            exit();
        } else {
            if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Email is required!'
                ]);
            } else if (!$this->utils()->checkEmail($_POST['email'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Invalid email format!'
                ]);
            } else  if ($this->model('Account')->is_email_exit($_POST['email'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Email was used by another account!'
                ]);
            } else if (!isset($_POST['phoneNumber']) || empty(trim($_POST['phoneNumber']))) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Phone number is required!'
                ]);
            } else if (!$this->utils()->checkPhoneNumber($_POST['phoneNumber'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Invalid phone format!'
                ]);
            } else if ($this->model('Account')->is_phone_number_exit($_POST['phoneNumber'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Phone number was used by another account!'
                ]);
            } else if (!isset($_POST['fullName']) || empty(trim($_POST['fullName']))) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Full name is required!'
                ]);
            } else if (!$this->utils()->checkName($_POST['fullName'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Only letters and white space allowed!'
                ]);
            } else if (!isset($_POST['address']) || empty(trim($_POST['address']))) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Address is required!'
                ]);
            } else if (!isset($_POST['date']) || empty(trim($_POST['date']))) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Date is required!'
                ]);
            } else if (!$this->utils()->checkTimeStamp($_POST['date'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Date is not allow!'
                ]);
            } else if (!isset($_FILES['idCard1']) || $_FILES['idCard1']['size'] === 0) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Id card image is required!'
                ]);
            } else if (!isset($_FILES['idCard2']) ||  $_FILES['idCard2']['size'] === 0) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Id card image is required!'
                ]);
            } else {
                $address = $_POST['address'];
                $fullName = $_POST['fullName'];
                $date = date('d/m/y', $_POST['date']);
                // echo date('m/d/Y',$_POST['date']);
                $phoneNumber = $_POST['phoneNumber'];
                $email = $_POST['email'];
                $passwordDefault = $this->utils()->generateRandomString();
                $password = password_hash($passwordDefault, PASSWORD_DEFAULT);
                $imageValidate1 = $this->utils()->uploadImage($_FILES['idCard1']);
                $imageValidate2 = $this->utils()->uploadImage($_FILES['idCard2']);
                if (!$imageValidate1['status']) {
                    echo json_encode($imageValidate1);
                } else if (!$imageValidate2['status']) {
                    echo json_encode($imageValidate2);
                } else {
                    $idCard1 = $imageValidate1['path'];
                    $idCard2 = $imageValidate2['path'];
                    $result = $this->model('Account')->add_Account($email, $phoneNumber, $password, $fullName, $address, $date, $idCard1, $idCard2);
                    if ($result) {
                        if ($this->utils()->sendMail($phoneNumber, $passwordDefault, $email)) {
                            echo json_encode([
                                "status" => true,
                                "msg" => "Create Successfully!! Please check your email to get your username and password.",
                                "redirect" => "../login"
                            ]);
                        } else {
                            echo json_encode([
                                "status" => false,
                                "msg" => "An error occurred while creating, please try again.",
                                "redirect" => ""
                            ]);
                        }
                    } else {
                        return json_encode([
                            "status" => false,
                            "msg" => "Failed to register account!",
                        ]);
                    }
                };
            }
        }
    }

    function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => false,
                'msg' => 'Method not allowed!'
            ]);
            exit();
        } else {
            if (!isset($_SESSION['authenticated'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Please login first'
                ]);
            } else if (!isset($_POST['oldPassword']) || empty(trim($_POST['oldPassword']))) {
                echo json_encode([
                    'status' => $_POST,
                    'msg' => 'Old password is required'
                ]);
            } else if (!$this->model('Account')->login($_SESSION['username'], $_POST['oldPassword'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Your password is not correct!'
                ]);
            } else if (!isset($_POST['newPassword']) || empty(trim($_POST['newPassword']))) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'New password is required'
                ]);
            } else if (strlen($_POST['newPassword']) != 6) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Password must be 6 characters!'
                ]);
            } else if (!isset($_POST['confirmPassword']) || empty(trim($_POST['confirmPassword']))) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Confirmation password is required'
                ]);
            } else if ($_POST['confirmPassword'] !== $_POST['newPassword']) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Your password and confirmation password do not match.'
                ]);
            } else {
                $newPassword = $_POST['newPassword'];
                $password = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->model('Account')->updateActive(true, $_SESSION['username']);
                if ($this->model('Account')->updatePassword($password, $_SESSION['username'])) {
                    echo json_encode([
                        'status' => true,
                        'msg' => 'Update Password Successfully!',
                        'redirect' => '../'
                    ]);
                }
            }
        }
    }

    function getActivatedAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode([
                'status' => false,
                'msg' => 'Method not allowed!'
            ]);
            exit();
        } else {
            // $validCondition = !isset($_SESSION['authenticated']) || $_SESSION['role'] != 'admin';
            // Cái này kiểm tra phân quyền, chỉ cho phép Admin truy cập
            // Nhưng do chưa có phân quyền nên tạm thời để như này
            $validCondition = true;
            if (!$validCondition) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Unthorization! You are not allowed to access this endpoint!'
                ]);
                exit();
            } else {
                $data = $this->model('Account')->getAccountByActiveStatus(1);
                echo json_encode([
                    'status' => true,
                    'msg' => 'Success.',
                    'data' => $data,
                ]);
                exit();
            }
        }
    }

    function getPendingAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode([
                'status' => false,
                'msg' => 'Method not allowed!'
            ]);
            exit();
        } else {
            // $validCondition = !isset($_SESSION['authenticated']) || $_SESSION['role'] != 'admin';
            // Cái này kiểm tra phân quyền, chỉ cho phép Admin truy cập
            // Nhưng do chưa có phân quyền nên tạm thời để như này
            $validCondition = true;
            if (!$validCondition) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Unthorization! You are not allowed to access this endpoint!'
                ]);
                exit();
            } else {
                $data = $this->model('Account')->getAccountByActiveStatus(0);
                echo json_encode([
                    'status' => true,
                    'msg' => 'Success.',
                    'data' => $data,
                ]);
                exit();
            }
        }
    }
}
