<?php 

class HomeController
{
    public $modelSanPham;

    public function __construct()
    {
        // Khởi tạo model SanPham
        $this->modelSanPham = new SanPham();
    }
    public function home()
    {
       echo "đây là home";
    }
    public function tranhChu()
    {
        echo "đây là trang chủ";
    }
    public function danhSachSanPham()
    {
        // echo "đây là danh sách sản phẩm";
        $listProduct = $this->modelSanPham->getAllProduct();
        // var_dump($listProduct);die();
        require_once './views/listProduct.php';
    }
}