<?php
class news extends Controller
{
    public $TinhTongmodel;
    public $SinhVienModel;
    public function __construct()
    {
        // $this->TinhTongmodel = $this->model('TinhTongmodel');
        // $this->SinhVienModel = $this->model('SinhVienModel');
    }
    function show()
    {
        // model
        // gán tmp cho model TinhTongmodel đã khởi tạo 
        // hàm sum trong model
        // $tong = $this->TinhTongmodel->sum(4, 5);
        // $dssv = $this->SinhVienModel->SinhVien();

        // view
        // $this->view("master2", [
        //     "number" => $tong,
        //     "mau" => "red",
        //     "SV" => $dssv
        // ]);
    }
}
