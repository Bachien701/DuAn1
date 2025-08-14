<?php 
class AdminDanhMucController {

        public $modelDanhMuc;

        public function __construct() 
        {
            $this->modelDanhMuc = new AdminDanhMuc(); // Khởi tạo mô hình danh mục
        }
        public function danhSachDanhMuc() {

            $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc(); // Lấy danh sách danh mục từ mô hình

            require_once './views/danhmuc/listDanhMuc.php'; // Khai báo biến môi trường
    }

    public function formAddDanhMuc(){
        // Hàm này dùng để hiển thị form nhập
        require_once './views/danhmuc/addDanhMuc.php';
    }
      public function postAddDanhMuc(){
        // Hàm này dùng để sử lý thêm dữ liệu

       // kiểm tra xem dữ liệu có phải được submit lên k
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           // Lấy dữ liệu từ form
           $ten_danh_muc = $_POST['ten_danh_muc'] ?? '';
           $mo_ta = $_POST['mo_ta'] ?? '';


           // Tạo 1 mảng trống để chứa dữ liệu
           $errors = [];
           if (empty($ten_danh_muc)) {
               $errors['ten_danh_muc'] = 'Tên danh mục không được để trống';
           }
           
           // Nếu không có lỗi thì tiến hành thêm danh mục
           if (empty($errors)) {
                // nếu k có lỗi thì tiến hành thêm danh mục
                // var_dump('ok');

                $this->modelDanhMuc->insertDanhMuc($ten_danh_muc, $mo_ta);
                header('Location: ' . BASE_URL_ADMIN . '?act=danh-muc'); // Chuyển hướng về danh sách danh mục
                exit();
           }else {
                // Trả về form và lỗi
                 require_once './views/danhmuc/addDanhMuc.php'; 
           }
        }
    }

     public function formEditDanhMuc(){
        // Hàm này dùng để hiển thị form nhập
        // lấy ra thông tin danh mục cần sửa
        $id = $_GET['id_danh_muc']; // Lấy id danh mục từ URL
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        if ($danhMuc) {
            require_once './views/danhmuc/editDanhMuc.php';
        }else {
              header('Location: ' . BASE_URL_ADMIN . '?act=danh-muc'); 
              exit();
        }
    }
        
      public function postEditDanhMuc(){
        // Hàm này dùng để sử lý thêm dữ liệu

       // kiểm tra xem dữ liệu có phải được submit lên k
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           // Lấy dữ liệu từ form
           $id = $_POST['id'];
           $ten_danh_muc = $_POST['ten_danh_muc'];
           $moTa = $_POST['mo_ta'];

           // Tạo 1 mảng trống để chứa dữ liệu
           $errors = [];
           if (empty($ten_danh_muc)) {
               $errors['ten_danh_muc'] = 'Tên danh mục không được để trống';
           }
           
           // Nếu không có lỗi thì tiến hành sửa danh mục
           if (empty($errors)) {
                // nếu k có lỗi thì tiến hành sửa danh mục
                // var_dump('ok');

                $this->modelDanhMuc->updateDanhMuc($id ,$ten_danh_muc, $moTa);
                header('Location: ' . BASE_URL_ADMIN . '?act=danh-muc'); // Chuyển hướng về danh sách danh mục
                exit();
           }else {
                // Trả về form và lỗi
                $danhMuc = [
                    'id' => $id,
                    'ten_danh_muc' => $ten_danh_muc,
                    'mo_ta' => $moTa
                ];
                 require_once './views/danhmuc/editDanhMuc.php'; 
           }
        }
    }

    public function deleteDanhMuc() {
        $id = $_GET['id_danh_muc']; 
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);

        if ($danhMuc) {
            $this->modelDanhMuc->destroyDanhMuc($id);
        }
         header('Location: ' . BASE_URL_ADMIN . '?act=danh-muc'); 
              exit();
    }
}
