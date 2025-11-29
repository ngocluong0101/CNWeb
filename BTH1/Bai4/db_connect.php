<?php
    // Cấu hình CSDL
    $host = 'localhost';
    $dbname = 'cnw_btth01'; 
    $username = 'root';     
    $password = '';         
    $charset = 'utf8mb4';
    $port = '3307'; 

    // Cấu hình DSN (Data Source Name)
    $dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=$charset"; 

    // Các tùy chọn kết nối PDO
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        // Tạo đối tượng PDO (Kết nối CSDL)
        $pdo = new PDO($dsn, $username, $password, $options);
        
    } catch (\PDOException $e) {
        // Xử lý lỗi kết nối
        die("LỖI KẾT NỐI CSDL (Port: $port): Kiểm tra cấu hình Port và CSDL. Thông báo lỗi: " . $e->getMessage());
    }
?>