<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | Kostku</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>

</html>