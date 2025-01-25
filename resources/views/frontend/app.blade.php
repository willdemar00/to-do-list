<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/app.css')}}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/header.css')}}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/menu.css')}}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/style.css')}}">
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-UG8ao2jwOWB7/oDdObZc6ItJmwUkR/PfMyt9Qs5AwX7PsnYn1CRKCTWyncPTWvaS" crossorigin="anonymous"></script>
    <script src="{{asset('build/assets/js/sidebar.js')}}"></script>
    <script src="{{asset('build/assets/js/menu.js')}}"></script>
    @yield('script')
</body>

</html>
