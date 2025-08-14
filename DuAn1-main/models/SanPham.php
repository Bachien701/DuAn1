<?php
class SanPham{
   public $conn; // khai báo phương thức

   public function __construct()
   {
      $this->conn = connectDB(); // gọi hàm kết nối CSDL
   }

   // viết hàm lấy toàn bộ danh sách sản phẩm
   public function getAllProduct(){
      try {
        $spl = "SELECT * FROM san_phams";

        $stmt = $this->conn->prepare($spl);

        $stmt->execute();

        return $stmt->fetchAll(); // trả về toàn bộ dữ liệu
      } catch (Exception $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
      }
   }
}