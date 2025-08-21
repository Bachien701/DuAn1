<?php 
class AdminDonHang{
   public $conn;
    public function __construct() {
         $this->conn = connectDB(); // Kết nối đến cơ sở dữ liệu
    }

    public function getAllDonHang() {
        try {
            $sql = "SELECT don_hang.*, trang_thai_don_hangs.ten_trang_thai
            FROM don_hangs 
            INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();  
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

         public function getAllTrangThaiDonHang() {
        try {
            $sql = "SELECT * FROM trang_thai_don_hangs';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();  
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }
    
    public function getDetailDonHang($id) {
        try {
            $sql = 'SELECT  don_hangs.*,
            trang_thai_don_hangs.ten_trang_thai, 
            tai_khoans.ho_ten,
            tai_khoans.email, 
            tai_khoans.so_dien_thoai
            phuong_thuc_thanh_toans.ten_phuong_thuc
            FROM don_hangs
            INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
            INNER JOIN tai_khoans ON don_hangs.trang_thai_id = tai_khoans.id
            INNER JOIN phuong_thuc_thanh_toans ON don_hangs.tai_khoan_id = phuong_thuc_thanh_toans.id
            WHERE don_hangs.id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetch();  
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

      public function getListSpDonHang($id) {
        try {
            $sql = 'SELECT  chi_tiet_don_hangs.*, san_pham.ten_san_pham
            FROM chi_tiet_don_hangs
            INNER JOIN san_pham ON chi_tiet_don_hang.san_pham_id = san_phams.id
            WHERE chi_tiet_don_hangs.don_hang_id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();  
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }
    public function updateDonHang( $id, $ten_nguoi_nhan,$sdt_nguoi_nhan,$email_nguoi_nhan,$dia_chi_nguoi_nhan,$ghi_chu,$trang_thai_id,
                ); {
        try {
        // var_dump($id);die;
            $sql = 'UPDATE don_hangs
                    SET

                ten_nguoi_nhan = :ten_nguoi_nhan,
                sdt_nguoi_nhan = :sdt_nguoi_nhan,
                email_nguoi_nhan = :email_nguoi_nhan,
                dia_chi_nguoi_nhan =: dia_chi_nguoi_nhan,
                ghi_chu = :ghi_chu,
                trang_thai_id = :trang_thai_id,
                
            WHERE id = :id';
            $stmt = $this->conn->prepare($sql);

            var_dump($stmt);die;
            $stmt->execute([
                ':ten_nguoi_nhan' => $ten_nguoi_nhan,
                ':sdt_nguoi_nhan' => $sdt_nguoi_nhan,
                ':email_nguoi_nhan' => $email_nguoi_nhan,
                ':dia_chi_nguoi_nhan' => $dia_chi_nguoi_nhan,
                ':ghi_chu' => $ghi_chu,
                ':id' => $trang_thai_id,
                
                
                



            return $this->conn->lastInsertId(); // Trả về ID của sản phẩm vừa thêm;  
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }


     public function insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh) {
        try {
            $sql = "INSERT INTO hinh_anh_san_phams (san_pham_id, link_hinh_anh)
            VALUES (:san_pham_id, :link_hinh_anh)";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':san_pham_id' => $san_pham_id,
                ':link_hinh_anh' => $link_hinh_anh
            ]);

            return true; 
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }


    public function getDetailSanPham($id) {
        try {
            $sql = "SELECT  san_phams WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetch();  
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

     public function getListAnhSanPham($id) {
        try {
            $sql = "SELECT * FROM hinh_anh_san_phams WHERE san_pham_id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();  
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }


}