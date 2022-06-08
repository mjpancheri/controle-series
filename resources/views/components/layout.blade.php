<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ $title }}</title>
</head>
<body>
<div class="container">
    <h1>{{ $title }}</h1>

    {{ $slot }}
</div>
</body>
</html>
