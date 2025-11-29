<?php
// Bài tập Thực hành 01 - Công nghệ Web - Bài 01

// 1. Tạo mảng mưu trữ thông tin có tên flowers (tên hoa, mô tả, ảnh) [cite: 7]
$flowers = [
    [
        'id' => 1,
        'ten_hoa' => 'Hoa Do Quyen',
        'mo_ta' => 'Loài hoa tượng trưng cho tình yêu và sự lãng mạn, nở rộ trong mùa hè.',
        'anh' => 'doquyen.jpg' // Đảm bảo tệp ảnh tồn tại trong images/
    ],
    [
        'id' => 2,
        'ten_hoa' => 'Hoa Hai Duong',
        'mo_ta' => 'Tượng trưng cho sự thanh cao, quý phái, và thường nở vào dịp xuân.',
        'anh' => 'haiduong.jpg'
    ],
    [
        'id' => 3,
        'ten_hoa' => 'Hoa Mai',
        'mo_ta' => 'Luôn hướng về ánh mặt trời, mang lại niềm vui và năng lượng tích cực.',
        'anh' => 'mai.jpg'
    ],
    [
        'id' => 4,
        'ten_hoa' => 'Hoa Tuong Vy',
        'mo_ta' => 'Quốc hoa của Việt Nam, nở vào mùa hạ, tượng trưng cho sự thuần khiết.',
        'anh' => 'tuongvy.jpg'
    ],
    [
        'id' => 5,
        'ten_hoa' => 'Hoa Cam Tu Cau',
        'mo_ta' => 'Loại cây thường mọc thành bụi có hoa nở to thành từng chùm và đặc biệt thích hợp với mùa hè',
        'anh' => 'camtucau.jpg'
    ],
    [
        'id' => 6,
        'ten_hoa' => 'Hoa Cuc La Nho',
        'mo_ta' => 'Đây là loại hoa biểu trưng cho sự giàu có và trường thọ.',
        'anh' => 'cuclanho.jpg'
    ],
    [
        'id' => 7,
        'ten_hoa' => 'Hoa Da Yen Thao',
        'mo_ta' => 'Loài hoa tượng trưng cho sự kiên cường và bền bỉ trong cuộc sống.',
        'anh' => 'dayenthao.jpg'
    ],
    [
        'id' => 8,
        'ten_hoa' => 'Hoa Dong Tien',
        'mo_ta' => 'Loài hoa tượng trưng cho sự may mắn và thịnh vượng.',
        'anh' => 'dongtien.jpg'
    ],
    [
        'id' => 9,
        'ten_hoa' => 'Hoa Cam Chuong',
        'mo_ta' => 'Loài hoa tượng trưng cho sự ấm áp và hạnh phúc gia đình.',
        'anh' => 'hoacamchuong.jpg'
    ],
    [
        'id' => 10,
        'ten_hoa' => 'Hoa Cuc Dai',
        'mo_ta' => 'Loài hoa biểu trưng cho sự kiên nhẫn và bền bỉ trong cuộc sống.',
        'anh' => 'hoacucdai.jpg'
    ],
    [
        'id' => 11,
        'ten_hoa' => 'Hoa Den Long',
        'mo_ta' => 'Hoa đèn lồng còn có tên là hồng đăng hoa, trồng trong chậu treo, bồn, phên dậu,… gieo hạt vào mùa xuân và cho hoa quanh năm.',
        'anh' => 'hoadenlong.jpg'
    ],
    [
        'id' => 12,
        'ten_hoa' => 'Hoa Dua Can',
        'mo_ta' => 'Quốc hoa của Việt Nam, nở vào mùa hạ, tượng trưng cho sự thuần khiết.',
        'anh' => 'hoaduacan.jpg'
    ],
    [
        'id' => 13,
        'ten_hoa' => 'Hoa Sen',
        'mo_ta' => 'Quốc hoa của Việt Nam, nở vào mùa hạ, tượng trưng cho sự thuần khiết.',
        'anh' => 'hoasen.jpg'
    ],
    [
        'id' => 14,
        'ten_hoa' => 'Hoa Thanh Tu',
        'mo_ta' => 'Quốc hoa của Việt Nam, nở vào mùa hạ, tượng trưng cho sự thuần khiết.',
        'anh' => 'hoathanhtu.jpg'
    ],
    [
        'id' => 15,
        'ten_hoa' => 'Hoa Giay',
        'mo_ta' => 'Hoa giấy mỏng manh nhưng rất lâu tàn, với nhiều màu như trắng, xanh, đỏ, hồng, tím, vàng… cùng nhiều sắc độ khác nhau.',
        'anh' => 'hoagiay.jpg'
    ]
];

// 2. Xác định loại người dùng dựa trên tham số URL (mode)
// Nếu không có tham số nào, mặc định là 'guest'
$user_role = isset($_GET['mode']) && $_GET['mode'] === 'admin' ? 'admin' : 'guest';
// Lấy tên file hiện tại (ví dụ: bai1.php)
$current_file = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 01: Hiển thị Danh sách Hoa</title>
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
    </style>
</head>
<body>

    <h1>Danh sách các loài hoa (Công nghệ Web K65)</h1>

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
    <?php if ($user_role == 'guest'): ?>
        <h2>🌸 Dạng hiển thị cho Người dùng Khách</h2>
        <div class="guest-view">
            <div class="flower-list">
                <?php foreach ($flowers as $flower): ?>
                    <div class="flower-card">
                        <h3><?php echo $flower['ten_hoa']; ?></h3>
                        <img src="../images/<?php echo $flower['anh']; ?>" alt="<?php echo $flower['ten_hoa']; ?>">
                        <p><strong>Mô tả:</strong> <?php echo $flower['mo_ta']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($user_role == 'admin'): ?>
        <h2>🛠️ Dạng hiển thị cho Người dùng Quản trị</h2>
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
                        <td><?php echo $flower['id']; ?></td>
                        <td><?php echo $flower['ten_hoa']; ?></td>
                        <td><?php echo $flower['mo_ta']; ?></td>
                        <td><?php echo $flower['anh']; ?></td>
                        <td class="admin-actions">
                            <button class="btn-view" onclick="alert('Xem chi tiết hoa ID: <?php echo $flower['id']; ?>')">Xem (R)</button>
                            <button class="btn-edit" onclick="alert('Chỉnh sửa hoa ID: <?php echo $flower['id']; ?>')">Sửa (U)</button>
                            <button class="btn-delete" onclick="alert('Xóa hoa ID: <?php echo $flower['id']; ?>')">Xóa (D)</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>