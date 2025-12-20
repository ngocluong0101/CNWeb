<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý sự cố máy tính</title>

<!-- Google Font + Icons -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<!-- Bootstrap 4 (giống file mẫu CRUD) -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<style>
body {
	color: #566787;
	background: #f5f5f5;
	font-family: 'Varela Round', sans-serif;
	font-size: 13px;
}
.table-wrapper {
	background: #fff;
	padding: 20px 25px;
	border-radius: 3px;
	min-width: 1000px;
	box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {
	background: #435d7d;
	color: #fff;
	padding: 16px 30px;
	margin: -20px -25px 10px;
	border-radius: 3px 3px 0 0;
}
.table-title h2 {
	margin: 5px 0 0;
	font-size: 24px;
}
.table-title .btn {
	color: #fff;
	font-size: 13px;
	border: none;
	min-width: 50px;
	border-radius: 2px;
}
table.table tr th,
table.table tr td {
	padding: 12px 15px;
	vertical-align: middle;
}
table.table-striped tbody tr:nth-of-type(odd) {
	background-color: #fcfcfc;
}
table.table-hover tbody tr:hover {
	background: #f5f5f5;
}
</style>
</head>

<body>
<div class="container-xl mt-4">
	<div class="table-responsive">
		<div class="table-wrapper">

			<!-- TIÊU ĐỀ -->
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Quản lý <b>Sự cố máy tính</b></h2>
					</div>
					<div class="col-sm-6 text-right">
						<a href="{{ route('issues.create') }}" class="btn btn-success">
							<i class="material-icons">&#xE147;</i>
							<span>Thêm vấn đề</span>
						</a>
					</div>
				</div>
			</div>

			<!-- THÔNG BÁO -->
			@if(session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif

			<!-- BẢNG -->
			<table class="table table-striped table-hover text-center">
				<thead class="thead-dark">
					<tr>
						<th>Mã</th>
						<th>Tên máy</th>
						<th>Phiên bản</th>
						<th>Người báo cáo</th>
						<th>Thời gian</th>
						<th>Mức độ</th>
						<th>Trạng thái</th>
						<th width="150">Hành động</th>
					</tr>
				</thead>

				<tbody>
				@forelse($issues as $issue)
					<tr>
						<td>{{ $issue->id }}</td>
						<td>{{ $issue->computer->computer_name }}</td>
						<td>{{ $issue->computer->model }}</td>
						<td>{{ $issue->reported_by }}</td>
						<td>{{ $issue->reported_date }}</td>

						<td>
							@if($issue->urgency == 'High')
								<span class="badge badge-danger">High</span>
							@elseif($issue->urgency == 'Medium')
								<span class="badge badge-warning">Medium</span>
							@else
								<span class="badge badge-success">Low</span>
							@endif
						</td>

						<td>
							@if($issue->status == 'Open')
								<span class="badge badge-secondary">Open</span>
							@elseif($issue->status == 'In Progress')
								<span class="badge badge-info">In Progress</span>
							@else
								<span class="badge badge-success">Resolved</span>
							@endif
						</td>

						<td>
							<a href="{{ route('issues.edit', $issue) }}"
							   class="btn btn-warning btn-sm">
								Sửa
							</a>

							<form action="{{ route('issues.destroy', $issue) }}"
								  method="POST"
								  style="display:inline"
								  onsubmit="return confirm('Bạn có chắc chắn muốn xóa vấn đề này?')">
								@csrf
								@method('DELETE')
								<button class="btn btn-danger btn-sm">
									Xóa
								</button>
							</form>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="8" class="text-muted text-center">
							Không có dữ liệu
						</td>
					</tr>
				@endforelse
				</tbody>
			</table>

			<!-- PHÂN TRANG -->
			<div class="clearfix">
				<div class="float-right">
					{{ $issues->links('pagination::bootstrap-4') }}
				</div>
			</div>

		</div>
	</div>
</div>
</body>
</html>
