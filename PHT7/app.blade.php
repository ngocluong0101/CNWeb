<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Website Của Tôi' }}</title>

    <style>
        body {
            font-family: sans-serif;
        }
        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }
        header, footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
        }
        nav {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <h1>Trang Web CSE485 - Chương 7</h1>
</header>

<nav>
    <a href="/">Trang Chủ</a>
    <a href="/about">Giới Thiệu</a>
</nav>

<div class="container">
    @yield('content')
</div>

<footer>
    <p>&copy; 2025 - Khoa CNTT - Trường Đại học Thủy Lợi</p>
</footer>

</body>
</html>
