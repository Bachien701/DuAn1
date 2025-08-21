<?php 
class AdminDonHangController {

        public $modelDonHang;
    

        public function __construct() 
        {
            $this->modelDonHang = new AdminDonHang(); // Khởi tạo mô hình sản phẩm
        }
        public function danhSachDonHang() {

            $listDonHang = $this->modelDonHang->getAllDonHang(); // Lấy danh sách danh mục từ mô hình

            require_once './views/DonHang/listDonHang.php'; // Khai báo biến môi trường
        }
            public function detailDonHang()
        {
                $don_hang_id = $_GET['id_don_hang'];
                // lấy thông tin  đon hàng ở bảng don_hangs
                $donHang = $this->modelDonHang->getDetailDonHang($don_hang_id);
                
                // lấy danh sách sản phẩm đã đặt của đơn hàng ở bảng chi_tiet_don_hangs
                $sanPhamDonHang =$this->modelDonHang->getListSpDonHang($don_hang_id);
               
                $listTrangThaiDonHang = $this->modelDonHang->getALLTrangThaiDonHang();
                require_once './views/donhang/detailDonHang.php';
        }
    


     public function formEditDonHang()
     {
        $id = $_GET['id_don_hang']; 
        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $listTrangThaiDonHang = $this->modelDonHang->getALLTrangThaiDonHang();
        if ($donHang) {
            require_once './views/donhang/editDonHang.php';
        }else {
              header('Location: ' . BASE_URL_ADMIN . '?act=don-hang'); 
              exit();
        }
    }
        
      public function postEditDonHang(){
        // Hàm này dùng để sử lý thêm dữ liệu

       // kiểm tra xem dữ liệu có phải được submit lên k
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           // lấy ra dữ liệu

           $don_hang_id = $_POST['don_hang_id'] ?? '';
           //truy vấn        
           $ten_nguoi_nhan =$_POST['ten_nguoi_nhan'] ?? '' ;
           $sdt_nguoi_nhan =$_POST['sdt_nguoi_nhan'] ?? '' ;
           $email_nguoi_nhan =$_POST['email_nguoi_nhan'] ?? '' ;
           $dia_Chi_nguoi_nhan =$_POST['dia_chi_nguoi_nhan'] ?? '' ;
           $ghi_chu =$_POST['ghi_chu'] ?? '' ;
           $trang_thai_id =$_POST['trang_thai_id'] ?? '' ;
           $ten_san_pham =$_POST['ten_san_pham'] ?? '' ;



        
           // Tạo 1 mảng trống để chứa dữ liệu
           $errors = [];
           if (empty($ten_nguoi_nhan)) {
               $errors['ten_nguoi_nhan'] = 'Tên người nhận không được để trống';
           }
           $errors = [];
           if (empty($sdt_nguoi_nhan)) {
               $errors['sdt_nguoi_nhan'] = 'SDT người nhận  không được để trống';
           }
           $errors = [];
           if (empty($email_nguoi_nhan)) {
               $errors['email_nguoi_nhan'] = 'email người nhận không được để trống';
           }
           $errors = [];
           if (empty($dia_chi_nguoi_nhan)) {
               $errors['dia_chi_nguoi_nhan'] = 'Địa chỉ người nhận không được để trống';
           }
           $errors = [];
           if (empty($trang_thai_id)) {
               $errors['trang_thai_id'] = 'Trạng thái đơn hàng';
           }
          

           $_SESSION['error'] = $errors;
           //var_dump($error);die;
           
           // Nếu không có lỗi thì tiến hành sửa danh mục
           if (empty($errors)) {
                // nếu k có lỗi thì tiến hành sửa danh mục
                // var_dump('ok');

                $this->modelDonHang->updateDonHang($don_hang_id,
                    $ten_nguoi_nhan,
                    $sdt_nguoi_nhan,
                    $email_nguoi_nhan,
                    $dia_chi_nguoi_nhan,
                    $ghi_chu,
                    $trang_thai_id,
                );
       
                header('Location: ' . BASE_URL_ADMIN . '?act=don_hang'); // Chuyển hướng về danh sách danh mục
                exit();
           }else {
                // Trả về form và lỗi
                // đặt chỉ thị xóa session sau khi hiển thị form
                $SESSION['flash'] = true;
                 header('Location: ' . BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang='); 
            
               
                
           }
        }
    }

    public function deleteDanhMuc() {
        $id = $_GET['id_danh_muc']; 
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);

        if ($danhMuc) {
            $this->modelDanhMuc->destroyDanhMuc($id);
        }
         header('Location: ' . BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang=' . $don_hang_id); 
              exit();
    }
}
