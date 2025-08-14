<?php 
class AdminDonHangController {

        public $modelDonHnag;
    

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
                var_dump($sanPhamDonHang);die;
                require_once './views/donhang/detailDonHang.php';
        }
    


    //  public function formEditSanPham(){
        // Hàm này dùng để hiển thị form nhập
        // lấy ra thông tin danh mục cần sửa
    //     $id = $_GET['id_san_pham']; // Lấy id danh mục từ URL
    //     $sanPham = $this->modelSanPham->getDetailSanPham($id);
    //     $listSanPham = $this->modelSanPham->getAllSanPham($id); // Lấy danh sách sản phẩm từ mô hình
    //     $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc(); // Lấy danh sách danh mục từ mô hình
    //     if ($sanPham) {
    //         require_once './views/sanpham/editSanPham.php';
    //     }else {
    //           header('Location: ' . BASE_URL_ADMIN . '?act=san-pham'); 
    //           exit();
    //     }
    // }
        
    //   public function postEditDanhMuc(){
    //     // Hàm này dùng để sử lý thêm dữ liệu

    //    // kiểm tra xem dữ liệu có phải được submit lên k
    //    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //        // Lấy dữ liệu từ form
    //        $id = $_POST['id'];
    //        $ten_danh_muc = $_POST['ten_danh_muc'];
    //        $moTa = $_POST['mo_Ta'];

    //        // Tạo 1 mảng trống để chứa dữ liệu
    //        $errors = [];
    //        if (empty($ten_danh_muc)) {
    //            $errors['ten_danh_muc'] = 'Tên danh mục không được để trống';
    //        }
           
    //        // Nếu không có lỗi thì tiến hành sửa danh mục
    //        if (empty($errors)) {
    //             // nếu k có lỗi thì tiến hành sửa danh mục
    //             // var_dump('ok');

    //             $this->modelDanhMuc->updateDanhMuc($id ,$ten_danh_muc, $moTa);
    //             header('Location: ' . BASE_URL_ADMIN . '?act=danh-muc'); // Chuyển hướng về danh sách danh mục
    //             exit();
    //        }else {
    //             // Trả về form và lỗi
    //             $danhMuc = [
    //                 'id' => $id,
    //                 'ten_danh_muc' => $ten_danh_muc,
    //                 'mo_ta' => $moTa
    //             ];
    //              require_once './views/danhmuc/editDanhMuc.php'; 
    //        }
    //     }
    // }

    // public function deleteDanhMuc() {
    //     $id = $_GET['id_danh_muc']; 
    //     $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);

    //     if ($danhMuc) {
    //         $this->modelDanhMuc->destroyDanhMuc($id);
    //     }
    //      header('Location: ' . BASE_URL_ADMIN . '?act=danh-muc'); 
    //           exit();
    // }
}
