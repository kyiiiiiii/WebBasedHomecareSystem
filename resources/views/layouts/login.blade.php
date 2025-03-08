<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://kit.fontawesome.com/8f346613dd.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        .bg-image {
            background-image: url('{{ asset('image/medical4.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .mask {
            width: 100%;
            min-height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Adjust the opacity as needed */
            color: white;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px); /* Apply the blur effect */
        }

        .content {
            position: relative;
            z-index: 1;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="bg-image"></div>
    <div class="mask">
        <main class="container-fluid content">
            @yield('content')
        </main>
    </div>
</body>
</html>
