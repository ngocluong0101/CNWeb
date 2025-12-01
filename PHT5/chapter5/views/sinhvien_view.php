<?php 
// View: chỉ chứa giao diện HTML, không chứa truy vấn SQL
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PHT Chương 5 - MVC</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2>Thêm Sinh Viên Mới (Kiến trúc MVC)</h2>

    <form method="POST">
        <input type="text" name="ten_sinh_vien" placeholder="Tên sinh viên" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">THÊM</button>
    </form>

    <h2>Danh Sách Sinh Viên (Kiến trúc MVC)</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên Sinh Viên</th>
            <th>Email</th>
            <th>Ngày Tạo</th>
        </tr>

        <?php 
        // TODO 4 & 5: hiển thị dữ liệu
        foreach ($danh_sach_sv as $sv) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($sv['id']) . "</td>";
            echo "<td>" . htmlspecialchars($sv['ten_sinh_vien']) . "</td>";
            echo "<td>" . htmlspecialchars($sv['email']) . "</td>";
            echo "<td>" . htmlspecialchars($sv['ngay_tao']) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>
</html>
