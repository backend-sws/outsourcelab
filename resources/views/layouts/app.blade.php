<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Av Wellcare Diagnostics</title>
    @include('partials.style')
</head>
<body class="bg-gray-50 text-gray-800">
    @include('partials.header')

    @yield('content')

    @include('partials.footer')
    
    @include('partials.scripts')
</body>
</html>
