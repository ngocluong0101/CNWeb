<?php
// BƯỚC 1: KẾT NỐI CSDL BẰNG PDO
include 'db_connect.php'; 

$message = '';
$error_msg = '';


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['data_file'])) {
    $file = $_FILES['data_file'];
    $file_type = pathinfo($file['name'], PATHINFO_EXTENSION);
    
    // Lấy đường dẫn tệp tạm thời
    $temp_file_path = $file['tmp_name']; 
    
    if (is_uploaded_file($temp_file_path)) {
        
        $pdo->beginTransaction(); // Bắt đầu Transaction cho toàn bộ quá trình import
        
        try {
            // 2. Xử lý Import dữ liệu (Đọc trực tiếp từ tệp tạm thời)
            if (strtolower($file_type) == 'csv') {
                $message .= import_csv_to_db($pdo, $temp_file_path); 
            } elseif (strtolower($file_type) == 'txt' || strtolower($file['name']) == 'quiz.txt') {
                $message .= import_quiz_txt_to_db($pdo, $temp_file_path);
            } else {
                $error_msg = "Lỗi: Định dạng tệp tin không được hỗ trợ để import (.csv hoặc .txt).";
            }
            
            $pdo->commit(); // Cam kết Transaction nếu import thành công
            
        } catch (Exception $e) {
            $pdo->rollBack(); // Hoàn tác nếu có lỗi
            // Thông báo lỗi an toàn cho người dùng
            $error_msg = "LỖI IMPORT DỮ LIỆU: Dữ liệu không được lưu vào CSDL. Vui lòng kiểm tra định dạng tệp tin và CSDL.";
            // Ghi lại lỗi chi tiết
            error_log("Lỗi Import: " . $e->getMessage());
        }

    } else {
        $error_msg = "Lỗi: Không tìm thấy tệp tạm thời hoặc tệp chưa được tải lên hoàn tất.";
    }
}

// ====================================================================
// A. HÀM XỬ LÝ IMPORT CSV (Tài khoản - Bài 3)
// Đảm bảo đọc TẤT CẢ các dòng qua vòng lặp while
// ====================================================================
function import_csv_to_db($pdo, $filepath) { 
    $imported_count = 0;
    
    try {
        if (($handle = fopen($filepath, "r")) !== FALSE) {
            fgetcsv($handle, 1000, ","); // Bỏ qua header
            
            $sql = "INSERT INTO accounts (username, password, lastname, firstname, city, email, course1) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // VÒNG LẶP ĐỌC TẤT CẢ CÁC DÒNG
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($row) != 7) continue; 

                try {
                    // Chèn TỪNG DÒNG dữ liệu
                    $stmt->execute($row); 
                    $imported_count++;
                } catch (PDOException $e) {
                    // Nếu có lỗi (ví dụ: trùng username UNIQUE), bỏ qua dòng đó và tiếp tục dòng kế tiếp
                    error_log("CSV Row Error: " . $e->getMessage() . " Data: " . implode(',', $row));
                }
            }
            
            fclose($handle);
            return "Import CSV thành công! Đã chèn **$imported_count** bản ghi vào bảng `accounts`.";
        }
    } catch (PDOException $e) {
        fclose($handle);
        // Ném ngoại lệ để kích hoạt rollback ở hàm gọi chính
        throw new PDOException("CSV File Error: " . $e->getMessage()); 
    }
    return "Lỗi: Không thể đọc tệp CSV.";
}


// B. HÀM XỬ LÝ IMPORT TXT (Quiz - Bài 2)
// ====================================================================
function import_quiz_txt_to_db($pdo, $filepath) {
    $content = file_get_contents($filepath);
    if ($content === false) {
        return "Lỗi: Không thể đọc tệp Quiz.txt.";
    }
    
    $imported_count = 0;

    try {
        // BƯỚC 1: Chuẩn hóa ký tự xuống dòng (LF, CR, CRLF) thành \n
        $content = str_replace(["\r\n", "\r"], "\n", $content);
        
        // BƯỚC 2: Tách các khối câu hỏi dựa trên hai ký tự xuống dòng liên tiếp
        // Thêm một vòng lặp để xóa các dòng trống thừa
        $content_clean = preg_replace("/\n\s*\n/", "\n\n", $content);
        
        // Vòng lặp phân tách TẤT CẢ các câu hỏi
        $questions_raw = explode("\n\n", trim($content_clean));

        $sql = "INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        foreach ($questions_raw as $raw_question) {
            $lines = array_map('trim', explode("\n", $raw_question));
            $lines = array_filter($lines); // Lọc bỏ các dòng trống

            if (count($lines) < 2) continue;

            $q_text = array_shift($lines); // Câu hỏi là dòng đầu tiên
            $options = [];
            $answer = '';

            foreach ($lines as $line) {
                if (strpos($line, 'ANSWER:') === 0) {
                    $answer = trim(substr($line, 7));
                } else if (preg_match('/^([A-Z])\.\s*(.*)/', $line, $matches)) {
                    $options[$matches[1]] = $matches[2];
                }
            }
            
            $params = [
                $q_text, $options['A'] ?? NULL, $options['B'] ?? NULL, 
                $options['C'] ?? NULL, $options['D'] ?? NULL, $answer
            ];

            try {
                if ($stmt->execute($params)) {
                    $imported_count++;
                }
            } catch (PDOException $e) {
                 error_log("Quiz Row Error: " . $e->getMessage() . " Data: " . $q_text);
            }
        }
        return "Import Quiz thành công! Đã chèn **$imported_count** câu hỏi vào bảng `questions`.";

    } catch (PDOException $e) {
        throw new PDOException("Quiz File Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài Tập 4: Upload và Lưu vào CSDL (PDO)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .message { padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px; border-radius: 4px; }
        .error { padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; margin-bottom: 20px; border-radius: 4px; }
        .upload-form { border: 1px solid #ddd; padding: 20px; border-radius: 8px; max-width: 500px; margin: 0 auto;}
        .form-control { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Bài 4 : Chức năng Upload File và Lưu trữ Dữ liệu Động (Sử dụng PDO)</h1>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <?php if ($error_msg): ?>
        <div class="error"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <div class="upload-form">
        <h2 style="text-align: center;">Tải lên tệp CSV/TXT</h2>
        <p style="text-align: center;">Hỗ trợ: Tệp .csv (Tài khoản) và tệp Quiz.txt (Câu hỏi).</p>
        <form action="upload_data.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="data_file" required style="margin-bottom: 15px;" accept=".csv, .txt" class="form-control"><br>
            <button type="submit" style="width: 100%; padding: 10px 15px; background-color: #ff9800; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1.1em;">
                Upload và Import Dữ liệu
            </button>
        </form>
    </div>

</body>
</html>