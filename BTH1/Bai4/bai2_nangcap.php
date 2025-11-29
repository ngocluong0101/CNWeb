<?php
// Bài tập 02 Nâng cấp: Đọc dữ liệu từ CSDL (Bảng questions)

// BƯỚC 1: KẾT NỐI CSDL
// Đảm bảo file này cung cấp đối tượng PDO với tên biến là $pdo
include 'db_connect.php'; 

$questions = [];
$error_message = null;

try {
    // BƯỚC 2: TRUY VẤN DỮ LIỆU TỪ BẢNG QUESTIONS
    $stmt = $pdo->query("SELECT * FROM questions ORDER BY id ASC");
    $db_questions = $stmt->fetchAll();
    
    // BƯỚC 3: CHUẨN HÓA DỮ LIỆU CSDL VỀ ĐỊNH DẠNG CŨ
    foreach ($db_questions as $q) {
        $correct_answers = array_map('trim', explode(',', $q['correct_answer']));
        
        // Tạo cấu trúc dữ liệu tương tự như khi phân tích file TXT
        $questions[] = [
            'q' => $q['question_text'],
            'options' => array_filter([ // Dùng array_filter để loại bỏ các option NULL nếu có
                'A' => $q['option_a'],
                'B' => $q['option_b'],
                'C' => $q['option_c'],
                'D' => $q['option_d'],
            ]),
            // Gán đáp án về dạng mảng đã chuẩn hóa (ví dụ: ['A'], ['C', 'D'])
            'answer' => array_map('trim', explode(',', $q['correct_answer'])) 
        ];
    }
    
    // Nếu không có câu hỏi nào được tải
    if (empty($questions)) {
        $error_message = "Không tìm thấy câu hỏi nào trong bảng 'questions'.";
    }

} catch (PDOException $e) {
    // Xử lý lỗi CSDL (ví dụ: bảng chưa tồn tại)
    $error_message = "Lỗi CSDL: " . $e->getMessage();
}

// BƯỚC 4: Logic chấm điểm và hiển thị kết quả (GIỮ NGUYÊN)
function normalize_set($arr) {
    $arr = array_map('strtoupper', $arr);
    sort($arr);
    return $arr;
}

$results = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $results = [];
    $score = 0;
    $total = count($questions);

    foreach ($questions as $i => $q) {

        $key = "q$i";
        // Lấy dữ liệu POST: Nếu là checkbox (multi), nó là mảng. Nếu là radio, nó là chuỗi.
        $user = $_POST[$key] ?? [];

        if (!is_array($user)) $user = [$user];
        $user = normalize_set($user);
        $correct = normalize_set($q['answer']); // $q['answer'] đã là mảng

        $ok = ($user == $correct);
        if ($ok) $score++;

        $results[] = [
            'q' => $q['q'],
            'correct' => $correct,
            'user' => $user,
            'is_correct' => $ok
        ];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Bài Thi Trắc Nghiệm (Đọc từ CSDL)</title>

<style>
body{font-family:Arial;background:#eef2ff;padding:20px}
.container{max-width:900px;margin:auto;background:white;padding:20px;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,.2)}
h1{text-align:center;color:#1e3a8a}
.card{padding:15px;border-left:4px solid #1e40af;margin:20px 0;background:#f8fafc;border-radius:6px}
.option{margin:6px 0}
.result{padding:10px;margin:10px 0;border-radius:5px}
.correct{background:#d1fae5;border:1px solid #10b981}
.wrong{background:#fee2e2;border:1px solid #ef4444}
button{padding:10px 20px;background:#1e3a8a;color:white;border:none;border-radius:6px;cursor:pointer}
.error-box{padding:15px;background:#fee2e2;border:1px solid #ef4444;border-radius:4px}
</style>

</head>
<body>

<div class="container">
<h1>Bài Thi Trắc Nghiệm (Đọc từ CSDL)</h1>

<?php if ($error_message): ?>
    <div class="error-box">
        <strong>LỖI DỮ LIỆU:</strong> <?= htmlspecialchars($error_message) ?><br>
        Vui lòng đảm bảo bạn đã import dữ liệu từ file **Quiz.txt** bằng file **upload_data.php** và bảng `questions` đã được tạo đúng cấu trúc.
    </div>
<?php else: ?>

<form method="post">

<?php foreach ($questions as $i => $q): ?>

    <?php
        // Tính toán loại input dựa trên số lượng đáp án đúng được lưu trong CSDL
        $is_multi = count($q['answer']) > 1; 
        $name = "q$i" . ($is_multi ? "[]" : "");
    ?>

    <div class="card">
        <b>Câu <?= $i+1 ?>:</b> <?= htmlspecialchars($q['q']) ?><br><br>

        <?php foreach ($q['options'] as $key => $text): ?>
            <?php if (!empty($text)): // Chỉ hiển thị nếu option đó có nội dung ?>
            <div class="option">
                <label>
                    <input type="<?= $is_multi ? 'checkbox' : 'radio' ?>"
                           name="<?= $name ?>"
                           value="<?= $key ?>">
                    <b><?= $key ?>.</b> <?= htmlspecialchars($text) ?>
                </label>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

<?php endforeach; ?>

<button type="submit">Nộp Bài Thi</button>

</form>

<?php if ($results !== null): ?>

    <h2>KẾT QUẢ</h2>
    <p>Điểm: <b><?= $score ?>/<?= count($questions) ?></b></p>

    <?php foreach ($results as $i => $r): ?>
        <div class="result <?= $r['is_correct'] ? 'correct' : 'wrong' ?>">
            <b>Câu <?= $i+1 ?>:</b><br>
            Đáp án đúng: <?= implode(", ", $r['correct']) ?><br>
            Bạn chọn: <?= empty($r['user']) ? "<i>Không chọn</i>" : implode(", ", $r['user']) ?>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

<?php endif; ?>

</div>

</body>
</html>