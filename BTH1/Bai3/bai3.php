<?php
// Bài tập Thực hành 01 - Công nghệ Web - Bài 03

// Tên tệp tin CSV
$csv_file = '65HTTT_Danh_sach_diem_danh.csv'; // 

// 1. Hàm đọc tệp CSV và trả về dữ liệu
function read_csv($filename) {
    $data = [];
    $handle = @fopen($filename, "r"); // Mở tệp tin để đọc
    
    if ($handle === FALSE) {
        return "Lỗi: Không thể tìm thấy hoặc mở tệp CSV. Hãy đảm bảo tệp nằm trong cùng thư mục với bai3.php";
    }

    // Đọc dòng đầu tiên để lấy header (tên các cột)
    $header = fgetcsv($handle, 1000, ",");
    
    if ($header === FALSE) {
        fclose($handle);
        return "Lỗi: Tệp CSV trống hoặc không có header.";
    }

    // Đọc các dòng còn lại để lấy dữ liệu
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if (count($header) == count($row)) {
            // Kết hợp header và row thành mảng kết hợp (Associative Array)
            $data[] = array_combine($header, $row);
        } else {
             // Bỏ qua các dòng bị thiếu hoặc thừa cột
             // echo "Cảnh báo: Bỏ qua dòng bị lỗi định dạng.";
        }
    }
    
    fclose($handle);
    return $data;
}

$account_data = read_csv($csv_file);

// Kiểm tra nếu dữ liệu là chuỗi lỗi
if (!is_array($account_data)) {
    die("Lỗi: " . $account_data);
}

// Kiểm tra nếu không có dữ liệu
if (empty($account_data)) {
    die("Không có dữ liệu nào được đọc từ tệp CSV.");
}

// Lấy tên các cột (header) từ phần tử đầu tiên
$headers = array_keys($account_data[0]);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 03: Đọc và Hiển thị Tệp CSV</title>
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
    </style>
</head>
<body>

    <h1>Danh sách Tài khoản (Đọc từ tệp CSV)</h1>
    <p>Hiển thị nội dung tệp tin <?php echo htmlspecialchars($csv_file); ?> (tiền đề cho hoạt động lưu vào CSDL).</p>
    
    

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

</body>
</html>