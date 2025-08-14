<?php 
class AdminSanPhamController {

        public $modelSanPham;
        public $modelDanhMuc;

        public function __construct() 
        {
            $this->modelSanPham = new AdminSanPham(); // Khởi tạo mô hình sản phẩm
            $this->modelDanhMuc = new AdminDanhMuc(); // Khởi tạo mô hình sản phẩm
        }
        public function danhSachSanPham() {

            $listSanPham = $this->modelSanPham->getAllSanPham(); // Lấy danh sách danh mục từ mô hình

            require_once './views/sanpham/listSanPham.php'; // Khai báo biến môi trường
    }

    public function formAddSanPham(){
        // Hàm này dùng để hiển thị form nhập
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc(); 
        
        require_once './views/sanpham/addSanPham.php';

        // Xoá session khi load trang
        deleteSessionError();
    }
      public function postAddSanPham(){
        // Hàm này dùng để sử lý thêm dữ liệu
      
       // kiểm tra xem dữ liệu có phải được submit lên k
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           // Lấy dữ liệu từ form
           $ten_san_pham = $_POST['ten_san_pham'];
           $gia_san_pham = $_POST['gia_san_pham'];
           $gia_khuyen_mai = $_POST['gia_khuyen_mai'];
           $so_luong = $_POST['so_luong'];
           $ngay_nhap = $_POST['ngay_nhap'];
           $danh_muc_id = $_POST['danh_muc_id'];
           $trang_thai = $_POST['trang_thai'];
           $mo_ta = $_POST['mo_ta'];

           $hinh_anh = $_FILES['hinh_anh'] ?? null; // Lấy hình ảnh từ form

           // Lưu hình ảnh vào
           $file_thumb = uploadFile($hinh_anh, './uploads'); // Lưu hình ảnh vào thư mục


           $img_array = $_FILES['img_array'] ?? null; // Lấy album ảnh


           // Tạo 1 mảng trống để chứa dữ liệu

           $errors = [];

           if (empty($ten_san_pham)) {
               $errors['ten_san_pham'] = 'Tên sản phẩm không được để trống';
           }

           if (empty($gia_san_pham)) {
               $errors['gia_san_pham'] = 'Giá sản phẩm không được để trống';
           }

           if (empty($gia_khuyen_mai)) {
               $errors['gia_khuyen_mai'] = 'Giá khuyến mãi không được để trống';
           }

           if (empty($so_luong)) {
               $errors['so_luong'] = 'Số lượng không được để trống';
           }

           if (empty($ngay_nhap)) {
               $errors['ngay_nhap'] = 'Ngày nhập không được để trống';
           }

           if (empty($danh_muc_id)) {
               $errors['danh_muc_id'] = 'Danh mục sản phẩm phải được chọn';
           }

           if (empty($trang_thai)) {
               $errors['trang_thai'] = 'Trạng thái sản phẩm phải được chọn';
           }

           if ($hinh_anh['error'] !== 0) {
               $errors['hinh_anh'] = 'Phải chọn hình ảnh sản phẩm';
           }

           $_SESSION['error'] = $errors; // Lưu lỗi vào session để hiển thị trong view

         

           
           // Nếu không có lỗi thì tiến hành thêm sản phẩm
           if (empty($errors)) {
                // nếu k có lỗi thì tiến hành thêm sản phẩm
                // var_dump('ok');

               $san_pham_id = $this->modelSanPham->insertSanPham(
                                                                 $ten_san_pham,
                                                                 $gia_san_pham, 
                                                                 $gia_khuyen_mai ,
                                                                 $so_luong, $ngay_nhap,
                                                                 $danh_muc_id , 
                                                                 $trang_thai , 
                                                                 $mo_ta , 
                                                                 $file_thumb);
                // xử lý thêm album ảnh sản phẩm img_array
                if (!empty($img_array['name'])) {
                    foreach ($img_array['name'] as $key=>$value) {
                        $file = [
                            'name' => $img_array['name'][$key],
                            'type' => $img_array['type'][$key],
                            'tmp_name' => $img_array['tmp_name'][$key],
                            'error' => $img_array['error'][$key],
                            'size' => $img_array['size'][$key]
                        ];

                        $link_hinh_anh = uploadFile($file, './uploads/'); // Lưu hình ảnh vào thư mục
                        $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh); // Thêm album ảnh vào cơ sở dữ liệu
                        }
                    }
                



                header('Location: ' . BASE_URL_ADMIN . '?act=san-pham'); // Chuyển hướng về danh sách sản phẩm
                exit();
           }else {
                // Trả về form và lỗi
               // Đặt chỉ thị xoá session sau khi hiện thi form
               $_SESSION['flash'] = true;

                header('Location: ' . BASE_URL_ADMIN . '?act=form-them-san-pham'); 
                exit();
           }
        }
    }

     public function formEditSanPham(){
        // Hàm này dùng để hiển thị form nhập
        // lấy ra thông tin san pham cần sửa
        $id = $_GET['id_san_pham'] ; // Lấy id danh mục từ URL
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id); // Lấy danh sách sản phẩm từ mô hình
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc(); // Lấy danh sách danh mục từ mô hình
        if ($sanPham) {
            require_once './views/sanpham/editSanPham.php';
            deleteSessionError(); 
        }else {
              header('Location: ' . BASE_URL_ADMIN . '?act=san-pham'); 
              exit();
        }
    }



          public function postEditSanPham(){
        // Hàm này dùng để sử lý thêm dữ liệu
      
       // kiểm tra xem dữ liệu có phải được submit lên k
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           // Lấy dữ liệu 
           // lấy ra dữ liễu cũ của sản phẩm
           $san_pham_id = $_POST['san_pham_id'] ?? '';
           // truy vấn
           $sanPhamOld = $this->modelSanPham->getDetailSanPham($san_pham_id);
           $old_file = $sanPhamOld['hinh_anh']; // Lấy hình ảnh cũ của sản phẩm
           

           $ten_san_pham = $_POST['ten_san_pham'];
           $gia_san_pham = $_POST['gia_san_pham'];
           $gia_khuyen_mai = $_POST['gia_khuyen_mai'];
           $so_luong = $_POST['so_luong'];
           $ngay_nhap = $_POST['ngay_nhap'];
           $danh_muc_id = $_POST['danh_muc_id'];
           $trang_thai = $_POST['trang_thai'];
           $mo_ta = $_POST['mo_ta'];

           $hinh_anh = $_FILES['hinh_anh'] ?? null; // Lấy hình ảnh từ form

      


           // Tạo 1 mảng trống để chứa dữ liệu

           $errors = [];

           if (empty($ten_san_pham)) {
               $errors['ten_san_pham'] = 'Tên sản phẩm không được để trống';
           }

           if (empty($gia_san_pham)) {
               $errors['gia_san_pham'] = 'Giá sản phẩm không được để trống';
           }

           if (empty($gia_khuyen_mai)) {
               $errors['gia_khuyen_mai'] = 'Giá khuyến mãi không được để trống';
           }

           if (empty($so_luong)) {
               $errors['so_luong'] = 'Số lượng không được để trống';
           }

           if (empty($ngay_nhap)) {
               $errors['ngay_nhap'] = 'Ngày nhập không được để trống';
           }

           if (empty($danh_muc_id)) {
               $errors['danh_muc_id'] = 'Danh mục sản phẩm phải được chọn';
           }

           if (empty($trang_thai)) {
               $errors['trang_thai'] = 'Trạng thái sản phẩm phải được chọn';
           }

           

           $_SESSION['error'] = $errors; // Lưu lỗi vào session để hiển thị trong view


           //login sủa ảnh
           if (isset($hinh_anh) && $hinh_anh['error'] == UPLOAD_ERR_OK) {
               // upload ảnh mới lên
               $new_file = uploadFile($hinh_anh, './uploads'); 
               if (!empty($old_file)) { // nếu có ảnh cũ thì xoá
                deleteFile($old_file); 
               }else {
                $new_file = $old_file; // nếu không có ảnh cũ thì giữ nguyên ảnh cũ
               }
           }

         

           
           // Nếu không có lỗi thì tiến hành thêm sản phẩm
           if (empty($errors)) {
                // nếu k có lỗi thì tiến hành thêm sản phẩm
                // var_dump('ok');

               $san_pham_id = $this->modelSanPham->updateSanPham($san_pham_id, 
                                                                 $ten_san_pham,
                                                                 $gia_san_pham, 
                                                                 $gia_khuyen_mai ,
                                                                 $so_luong, $ngay_nhap,
                                                                 $danh_muc_id , 
                                                                 $trang_thai , 
                                                                 $mo_ta , 
                                                                 $new_file
                                                                );
             
                



                header('Location: ' . BASE_URL_ADMIN . '?act=san-pham'); // Chuyển hướng về danh sách sản phẩm
                exit();
           }else {
                // Trả về form và lỗi
               // Đặt chỉ thị xoá session sau khi hiện thi form
               $_SESSION['flash'] = true;

                header('Location: ' . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $san_pham_id); 
                exit();
           }
        }
    }
        

    // sửa ablum ảnh
    // - sửa ảnh cữ
    //   + thêm ảnh mới
    //   + không thêm ảnh mới
    // - không sửa ảnh cũ
    //   + thêm ảnh mới
    //   + không thêm ảnh mới
    // - xoá ảnh cũ
    //   + thêm ảnh mới
    //   + không thêm ảnh mới



    public function postEditAnhSanPham() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $san_pham_id = $_POST['san_pham_id'] ?? '';

            // lấy danh sách ảnh hiện tại của sản phẩm
            $listAnhSanPhamCurrent = $this->modelSanPham->getListAnhSanPham($san_pham_id);

            // xử lý các ảnh được gửi từ form

            $img_array = $_FILES['img_array']; 
            $img_delete = isset($_POST['img_delete']) ? explode(',', $_POST['img_delete']) : [];
            $current_img_ids = $_POST['current_img_ids'] ?? [];

            // khai báo mảng để lưu ảnh mới hoặc thay thế
            $upload_files = [];

            // upload ảnh mới hay thay thế ảnh cũ
            foreach ($img_array['name'] as $key=>$value) {
                if ($img_array['error'][$key] == UPLOAD_ERR_OK) {
                    $new_file = uploadFileAlbum($img_array, './uploads/' , $key); 
                    if ($new_file) {
                        $upload_files[] = [
                            'id' => $current_img_ids[$key] ?? null,
                            'file' => $new_file
                        ]; 
                    }
                }
            }

            //lưu ảnh mới vào db và xoá ảnh cũ nếu có
            foreach ($upload_files as $file_info) {
                if ($file_info['id']) {
                    $old_file = $this->modelSanPham->getDetailAnhSanPham($file_info['id'])['link_hinh_anh'];

                    // cập nhập ảnh cũ
                    $this->modelSanPham->updateAnhSanPham($file_info['id'], $file_info['file']);

                    // xoá ảnh cũ nếu có
                    deleteFile($old_file);
                } else{
                    // thêm ảnh mới
                    $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $file_info['file']);
                }
            }

            // xử lý xoá ảnh 
            foreach ($listAnhSanPhamCurrent as $anhSP) {
                $anh_id = $anhSP['id'];
                if (in_array($anh_id, $img_delete)) {
                    // xoá ảnh trong db
                    $this->modelSanPham->destroyAnhSanPham($anh_id);
                    // xoá file ảnh
                    deleteFile($anhSP['link_hinh_anh']);
                }
            }
                header('Location: ' . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $san_pham_id); 
                exit();
        }
    }


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