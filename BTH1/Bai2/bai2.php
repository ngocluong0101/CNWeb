<?php

$quiz_file = __DIR__ . '/Quiz.txt';

if (!file_exists($quiz_file)) {
    die("Không tìm thấy Quiz.txt");
}

$text = file_get_contents($quiz_file);

// Tách câu hỏi theo 2 dòng trống trở lên
$raw_blocks = preg_split("/(\r?\n){2,}/", trim($text));

$questions = [];

foreach ($raw_blocks as $block) {

    $lines = preg_split("/\r?\n/", trim($block));
    if (count($lines) == 0) continue;

    // Tìm dòng chứa ANSWER:
    $answer_index = null;
    foreach ($lines as $i => $line) {
        if (preg_match('/^\s*ANSWER\s*:/i', $line)) {
            $answer_index = $i;
            break;
        }
    }

    if ($answer_index === null) continue;

    // Parse câu hỏi + đáp án
    $question_text = '';
    $options = [];

    for ($i = 0; $i < $answer_index; $i++) {
        $line = trim($lines[$i]);

        // HỖ TRỢ: A., A), **A.**, *A.* , [A], A - 
        if (preg_match('/^\**\s*\**\s*([A-Z])[\.\)\-]\**\s*(.+)$/', $line, $m)) {
            $label = strtoupper($m[1]);
            $opt = trim($m[2]);
            $options[$label] = $opt;
        } else {
            if (empty($options)) {
                $question_text .= ($question_text ? " " : "") . $line;
            } else {
                // nếu dòng tiếp tục mô tả option
                end($options);
                $last = key($options);
                $options[$last] .= " " . $line;
            }
        }
    }

    // Parse ANSWER:
    $ans_line = $lines[$answer_index];
    $ans = preg_replace('/ANSWER\s*:/i', '', $ans_line);
    $ans = trim(str_replace([','], ' ', $ans));
    $answer_arr = array_filter(array_map('trim', explode(' ', $ans)));

    $questions[] = [
        'q' => $question_text,
        'options' => $options,
        'answer' => $answer_arr
    ];
}

// chuẩn hoá mảng
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
        $user = $_POST[$key] ?? [];

        if (!is_array($user)) $user = [$user];
        $user = normalize_set($user);
        $correct = normalize_set($q['answer']);

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
<title>Bài Thi Trắc Nghiệm (Đọc từ tệp Quiz.txt)</title>

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
</style>

</head>
<body>

<div class="container">
<h1>Bài Thi Trắc Nghiệm (Đọc từ tệp Quiz.txt)</h1>

<form method="post">

<?php foreach ($questions as $i => $q): ?>

    <?php
        $is_multi = count($q['answer']) > 1;
        $name = "q$i" . ($is_multi ? "[]" : "");
    ?>

    <div class="card">
        <b>Câu <?= $i+1 ?>:</b> <?= htmlspecialchars($q['q']) ?><br><br>

        <?php foreach ($q['options'] as $key => $text): ?>
            <div class="option">
                <label>
                    <input type="<?= $is_multi ? 'checkbox' : 'radio' ?>"
                           name="<?= $name ?>"
                           value="<?= $key ?>">
                    <b><?= $key ?>.</b> <?= htmlspecialchars($text) ?>
                </label>
            </div>
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

</div>

</body>
</html>
