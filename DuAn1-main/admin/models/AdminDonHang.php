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

    
    public function getDetailDonHang($id) {
        try {
            $sql = 'SELECT  don_hang.*,trang_thai_don_hangs.ten_trang_thai
            FROM don_hangs
            INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
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
            $sql = 'SELECT  *FROMchi_tiet-don_hangs
            WHERE don_hang_id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();  
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }
//     public function insertSanPham($ten_san_pham, $gia_san_pham, $gia_khuyen_mai , $so_luong, $ngay_nhap, $danh_muc_id , $trang_thai , $mo_ta , $hinh_anh) {
//         try {
//             $sql = "INSERT INTO san_phams (ten_san_pham, gia_san_pham, gia_khuyen_mai, so_luong, ngay_nhap, danh_muc_id, trang_thai, mo_ta, hinh_anh)
//             VALUES (:ten_san_pham, :gia_san_pham, :gia_khuyen_mai, :so_luong, :ngay_nhap, :danh_muc_id, :trang_thai, :mo_ta, :hinh_anh)";

//             $stmt = $this->conn->prepare($sql);

//             $stmt->execute([
//                 ':ten_san_pham' => $ten_san_pham,
//                 ':gia_san_pham' => $gia_san_pham,
//                 ':gia_khuyen_mai' => $gia_khuyen_mai,
//                 ':so_luong' => $so_luong,
//                 ':ngay_nhap' => $ngay_nhap,
//                 ':danh_muc_id' => $danh_muc_id,
//                 ':trang_thai' => $trang_thai,
//                 ':mo_ta' => $mo_ta,
//                 ':hinh_anh' => $hinh_anh
//             ]);

//             return $this->conn->lastInsertId(); // Trả về ID của sản phẩm vừa thêm;  
//         } catch (Exception $e) {
//             echo "lỗi" . $e->getMessage();
//         }
//     }


//      public function insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh) {
//         try {
//             $sql = "INSERT INTO hinh_anh_san_phams (san_pham_id, link_hinh_anh)
//             VALUES (:san_pham_id, :link_hinh_anh)";

//             $stmt = $this->conn->prepare($sql);

//             $stmt->execute([
//                 ':san_pham_id' => $san_pham_id,
//                 ':link_hinh_anh' => $link_hinh_anh
//             ]);

//             return true; 
//         } catch (Exception $e) {
//             echo "lỗi" . $e->getMessage();
//         }
//     }


//     public function getDetailSanPham($id) {
//         try {
//             $sql = "SELECT  san_phams WHERE id = :id";

//             $stmt = $this->conn->prepare($sql);

//             $stmt->execute([':id' => $id]);

//             return $stmt->fetch();  
//         } catch (Exception $e) {
//             echo "lỗi" . $e->getMessage();
//         }
//     }

//      public function getListAnhSanPham($id) {
//         try {
//             $sql = "SELECT * FROM hinh_anh_san_phams WHERE san_pham_id = :id";

//             $stmt = $this->conn->prepare($sql);

//             $stmt->execute([':id' => $id]);

//             return $stmt->fetchAll();  
//         } catch (Exception $e) {
//             echo "lỗi" . $e->getMessage();
//         }
//     }


// }