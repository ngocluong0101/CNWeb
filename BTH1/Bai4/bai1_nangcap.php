<?php
// Bài tập 01 Nâng cấp: Đọc dữ liệu từ CSDL (Bảng flowers)

// BƯỚC 1: KẾT NỐI CSDL
// Đảm bảo file này cung cấp đối tượng PDO với tên biến là $pdo
include 'db_connect.php'; 

// 2. Xác định loại người dùng dựa trên tham số URL (mode)
$user_role = isset($_GET['mode']) && $_GET['mode'] === 'admin' ? 'admin' : 'guest';
$current_file = basename($_SERVER['PHP_SELF']);

$flowers = [];
$error_message = null;

try {
    // BƯỚC 2: TRUY VẤN DỮ LIỆU TỪ CSDL
    $stmt = $pdo->query("SELECT id, ten_hoa, mo_ta, anh FROM flowers ORDER BY id ASC");
    $flowers = $stmt->fetchAll();
    
} catch (PDOException $e) {
    // Xử lý lỗi nếu bảng chưa tồn tại hoặc kết nối sai
    $error_message = "Lỗi truy vấn CSDL: " . $e->getMessage();
}

// Lưu ý: Mảng $flowers tĩnh ban đầu đã bị loại bỏ và được thay thế bằng dữ liệu từ CSDL

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 01 Nâng cấp: Hiển thị Danh sách Hoa từ CSDL</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #3f51b5; }
        
        /* CSS cho Người dùng Khách */
        .guest-view { border-bottom: 2px solid #ccc; padding-bottom: 20px; margin-bottom: 20px; }
        .flower-list { display: flex; flex-wrap: wrap; gap: 30px; justify-content: flex-start; }
        .flower-card { 
            border: 1px solid #ddd; 
            padding: 15px; 
            width: 300px; 
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .flower-card img { 
            width: 100%; 
            height: 200px; /* Cố định chiều cao ảnh */
            object-fit: cover; /* Đảm bảo ảnh vừa khung mà không bị méo */
            margin-bottom: 10px; 
            border-radius: 4px;
        }
        .flower-card h3 { color: #e91e63; }

        /* CSS cho Người dùng Quản trị */
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .admin-table th, .admin-table td { 
            border: 1px solid #ccc; 
            padding: 10px; 
            text-align: left; 
            vertical-align: middle;
        }
        .admin-table th { background-color: #f2f2f2; }
        .admin-actions button { 
            margin-right: 5px; 
            padding: 5px 10px;
            cursor: pointer; 
            border: none;
            border-radius: 4px;
        }
        .btn-view { background-color: #4CAF50; color: white; }
        .btn-edit { background-color: #FFC107; color: black; }
        .btn-delete { background-color: #F44336; color: white; }
        .error-box { padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 20px; }
        .warning-box { padding: 15px; background-color: #fff3cd; color: #856404; border-color: #ffeeba; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h1>Danh sách các loài hoa (Đọc từ CSDL)</h1>

    <div style="margin-bottom: 20px;">
        <strong>Chế độ hiện tại: 
            <?php echo $user_role === 'admin' ? 'Quản trị (ADMIN)' : 'Khách (GUEST)'; ?>
        </strong>
        | 
        <?php if ($user_role === 'guest'): ?>
            <a href="<?php echo $current_file; ?>?mode=admin" style="color: blue; text-decoration: none; padding: 5px; border: 1px solid blue; border-radius: 4px;">
                Chuyển sang chế độ Quản trị
            </a>
        <?php else: ?>
            <a href="<?php echo $current_file; ?>?mode=guest" style="color: green; text-decoration: none; padding: 5px; border: 1px solid green; border-radius: 4px;">
                Chuyển sang chế độ Khách
            </a>
        <?php endif; ?>
    </div>
    <hr>
    
    <?php if ($error_message): ?>
        <div class="error-box">
            <p><strong>LỖI CSDL:</strong> <?php echo $error_message; ?></p>
            <p>Vui lòng đảm bảo bảng `flowers` đã được tạo và kết nối CSDL (`db_connect.php`) hoạt động đúng.</p>
        </div>
    <?php elseif (empty($flowers)): ?>
        <div class="warning-box">
            <p><strong>CẢNH BÁO:</strong> Không có dữ liệu hoa trong bảng `flowers`.</p>
            <p>Vui lòng thêm dữ liệu vào bảng `flowers` để hiển thị.</p>
        </div>
    <?php else: ?>
        <?php if ($user_role == 'guest'): ?>
            <h2>🌸 Dạng hiển thị cho Người dùng Khách</h2>
            <div class="guest-view">
                <div class="flower-list">
                    <?php foreach ($flowers as $flower): ?>
                        <div class="flower-card">
                            <h3><?php echo htmlspecialchars($flower['ten_hoa']); ?></h3>
                            <img src="../images/<?php echo htmlspecialchars($flower['anh']); ?>" alt="<?php echo htmlspecialchars($flower['ten_hoa']); ?>">
                            <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($flower['mo_ta']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($user_role == 'admin'): ?>
            <h2>🛠️ Dạng hiển thị cho Người dùng Quản trị (Bảng CRUD)</h2>
            <button style="padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Thêm mới (Create)</button>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên hoa</th>
                        <th>Mô tả</th>
                        <th>Ảnh (Tên file)</th>
                        <th>Thao tác (CRUD)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($flowers as $flower): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($flower['id']); ?></td>
                            <td><?php echo htmlspecialchars($flower['ten_hoa']); ?></td>
                            <td><?php echo htmlspecialchars($flower['mo_ta']); ?></td>
                            <td><?php echo htmlspecialchars($flower['anh']); ?></td>
                            <td class="admin-actions">
                                <button class="btn-view" onclick="alert('Xem chi tiết ID: <?php echo $flower['id']; ?>')">Xem (R)</button>
                                <button class="btn-edit" onclick="alert('Chỉnh sửa ID: <?php echo $flower['id']; ?>')">Sửa (U)</button>
                                <button class="btn-delete" onclick="alert('Xóa ID: <?php echo $flower['id']; ?>')">Xóa (D)</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>

</body>
</html>