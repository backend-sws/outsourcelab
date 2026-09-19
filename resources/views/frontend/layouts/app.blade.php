<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Av Wellcare Diagnostics</title>
    @include('frontend.partials.style')
</head>
<body class="bg-gray-50 text-gray-800 m-0 p-0">
    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')
    
    @include('frontend.partials.modals.login')
    @include('frontend.partials.modals.prescription')
    @include('patient.modals.add-member')
    @include('patient.modals.change-address')
    @include('patient.modals.add-address')
    
    @include('frontend.partials.floating-welcome-ticket')

    @include('frontend.partials.scripts')
</body>
</html>