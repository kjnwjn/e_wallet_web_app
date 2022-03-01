<?php
class Login extends Controller
{

    // public $RenderSlider;
    public $account;
    public function __construct()
    {
        // $this->RenderSlider = $this->model('Slider');
        $this->account = $this->model('Account');
    }
    function default()
    {
        // khởi tạo đối tượng tèo sử dụng được những hàm từ đối tượng sinhvienmodel
        // $a = 'quan@gmail.com';
        // $b = '123456';
        // // khời tạo đối tượng sử dụng view của home load ra data là danh sách student 

        // $dssv = $this->SinhVienModel->SinhVien();
        // $isEmail = $this->account->is_email_exit($a);
        $this->view('login', []);
    }
}
