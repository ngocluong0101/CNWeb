<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm vấn đề</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="text-success mb-3">➕ Thêm vấn đề mới</h3>

    <form method="POST" action="{{ route('issues.store') }}">
        @csrf

        <div class="mb-3">
            <label>Máy tính</label>
            <select name="computer_id" class="form-select" required>
                @foreach($computers as $c)
                    <option value="{{ $c->id }}">
                        {{ $c->computer_name }} - {{ $c->model }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Người báo cáo</label>
            <input type="text" name="reported_by" class="form-control">
        </div>

        <div class="mb-3">
            <label>Thời gian báo cáo</label>
            <input type="datetime-local" name="reported_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Mức độ</label>
            <select name="urgency" class="form-select">
                <option>Low</option>
                <option>Medium</option>
                <option>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-select">
                <option>Open</option>
                <option>In Progress</option>
                <option>Resolved</option>
            </select>
        </div>

        <button class="btn btn-success">Lưu</button>
        <a href="{{ route('issues.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

</body>
</html>
