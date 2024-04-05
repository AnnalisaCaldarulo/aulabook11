<!DOCTYPE html>

<html lang="it">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>AulaBook</title>

</head>

<body class="bg-body-secondary">
    <x-navbar />
    <div class="min-vh-100">

        @if (session()->has('errorMessage'))
            <div class="d-flex justify-content-center my-2 alert alert-danger">
                {{ session('errorMessage') }}
            </div>
        @endif
        {{ $slot }}
    </div>
    <x-footer />
</body>

</html>
