<?php
    // Controller: Điều hướng - xử lý yêu cầu - gọi Model - đẩy dữ liệu cho View

    // TODO 6: Import Model
    require_once 'models/SinhVienModel.php';

    // ================= KẾT NỐI PDO ===================
    // TODO 7: Copy code PDO từ PHT Chương 4 vào đây
    $host = '127.0.0.1';
    $dbname = 'cse485_web';
    $username = 'root';
    $password = '';
    $port = 3307;

    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        die("Kết nối thất bại: " . $e->getMessage());
    }
    // ==================================================

    // TODO 8: Kiểm tra hành động POST (thêm sinh viên)
    if (isset($_POST['ten_sinh_vien']) && isset($_POST['email'])) {
        
        // TODO 9: Nếu có, lấy $ten và $email từ $_POST
        $ten = $_POST['ten_sinh_vien'];
        $email = $_POST['email'];
        
        // TODO 10: Gọi hàm addSinhVien() từ Model
        addSinhVien($pdo, $ten, $email);

        // TODO 11: Chuyển hướng về index.php để "làm mới" trang
        header('Location: index.php');
        exit;
    }

    // TODO 12: (Luôn luôn) Gọi hàm getAllSinhVien() từ Model
    $danh_sach_sv = getAllSinhVien($pdo);

    // TODO 13: (Rất quan trọng) Import (include) tệp View ở cuối cùng
    include 'views/sinhvien_view.php';
?>
