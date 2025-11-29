<?php
// Bài tập 03 Nâng cấp: Đọc dữ liệu từ CSDL (Bảng accounts)

// BƯỚC 1: KẾT NỐI CSDL
// Đảm bảo file này cung cấp đối tượng PDO với tên biến là $pdo
include 'db_connect.php'; 

$account_data = [];
$error_message = null;

try {
    // BƯỚC 2: TRUY VẤN DỮ LIỆU TỪ BẢNG ACCOUNTS
    // Chọn các cột dữ liệu cần hiển thị (tránh chọn cột 'password' trong thực tế)
    $stmt = $pdo->query("SELECT username, lastname, firstname, city, email, course1 FROM accounts ORDER BY username ASC");
    
    // Lấy TẤT CẢ bản ghi
    $account_data = $stmt->fetchAll();

    if (!empty($account_data)) {
        // Lấy tên các cột (header) từ phần tử đầu tiên của mảng kết quả
        $headers = array_keys($account_data[0]);
    } else {
        $headers = [];
    }

} catch (PDOException $e) {
    // Xử lý lỗi nếu có vấn đề với CSDL (ví dụ: bảng chưa tồn tại)
    $error_message = "Lỗi truy vấn CSDL: " . $e->getMessage();
    $headers = [];
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 03 Nâng cấp: Đọc và Hiển thị Tài khoản từ CSDL</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #3f51b5; }
        .csv-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 0.9em; }
        .csv-table th, .csv-table td { 
            border: 1px solid #ccc; 
            padding: 10px; 
            text-align: left; 
        }
        .csv-table th { 
            background-color: #3f51b5; 
            color: white; 
            text-transform: uppercase;
        }
        .csv-table tr:nth-child(even) { background-color: #f2f2f2; }
        .csv-table tr:hover { background-color: #ddd; }
        .error-box { padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; }
        .warning-box { padding: 15px; background-color: #fff3cd; color: #856404; border-color: #ffeeba; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>Danh sách Tài khoản (Đọc từ CSDL)</h1>
    <p>Hiển thị dữ liệu động được lưu trữ trong bảng `accounts`.</p>
    
    <?php if ($error_message): ?>
        <div class="error-box">
            <p><strong>LỖI TRUY VẤN:</strong> <?php echo $error_message; ?></p>
            <p>Vui lòng đảm bảo bạn đã tạo bảng `accounts` và kết nối CSDL (`db_connect.php`) hoạt động đúng.</p>
        </div>
    <?php elseif (empty($account_data)): ?>
        <div class="warning-box">
            <p><strong>CẢNH BÁO:</strong> Không tìm thấy dữ liệu trong bảng `accounts`.</p>
            <p>Hãy chạy file **upload_data.php** và import file CSV để chèn dữ liệu vào CSDL.</p>
        </div>
    <?php else: ?>
        <table class="csv-table">
            <thead>
                <tr>
                    <?php foreach ($headers as $header): ?>
                        <th><?php echo htmlspecialchars($header); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($account_data as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?php echo htmlspecialchars($cell); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>