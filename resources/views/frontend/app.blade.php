<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/notificaton.css') }}">
    <title>@yield('title') - {{ config('app.name', 'TaskFlow') }}</title>
    @yield('styles')
</head>

<body class="body-expanded">
    @include('frontend.layout.partials.header')
    @include('frontend.layout.partials.menu')
    <main>
        @yield('content')
    </main>
    @include('frontend.layout.partials.footer')

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha384-UG8ao2jwOWB7/oDdObZc6ItJmwUkR/PfMyt9Qs5AwX7PsnYn1CRKCTWyncPTWvaS" crossorigin="anonymous">
    </script>
    <script src="{{ asset('build/assets/js/sidebar.js') }}"></script>
    <script src="{{ asset('build/assets/js/menu.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <x-flash-notification/>
    @yield('script')
</body>

</html>
