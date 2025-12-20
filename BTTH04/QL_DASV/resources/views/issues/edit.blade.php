<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa vấn đề</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="text-primary mb-3">✏️ Cập nhật vấn đề</h3>

    <form method="POST" action="{{ route('issues.update', $issue) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Máy tính</label>
            <select name="computer_id" class="form-select">
                @foreach($computers as $c)
                    <option value="{{ $c->id }}"
                        {{ $issue->computer_id == $c->id ? 'selected' : '' }}>
                        {{ $c->computer_name }} - {{ $c->model }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Người báo cáo</label>
            <input type="text" name="reported_by"
                   value="{{ $issue->reported_by }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Thời gian báo cáo</label>
            <input type="datetime-local" name="reported_date"
                   value="{{ date('Y-m-d\TH:i', strtotime($issue->reported_date)) }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ $issue->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Mức độ</label>
            <select name="urgency" class="form-select">
                <option {{ $issue->urgency=='Low'?'selected':'' }}>Low</option>
                <option {{ $issue->urgency=='Medium'?'selected':'' }}>Medium</option>
                <option {{ $issue->urgency=='High'?'selected':'' }}>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-select">
                <option {{ $issue->status=='Open'?'selected':'' }}>Open</option>
                <option {{ $issue->status=='In Progress'?'selected':'' }}>In Progress</option>
                <option {{ $issue->status=='Resolved'?'selected':'' }}>Resolved</option>
            </select>
        </div>

        <button class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('issues.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

</body>
</html>
