<!Doctype html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="imagem/png" href="{{ asset('assets/logo.svg') }}" />
    <title>{{ 'Sustainlbaw - ' . $title ?? ' ' }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"
        defer></script>

    <!--Fontawsome icons-->
    <script src="https://kit.fontawesome.com/f041e7a7a3.js" crossorigin="anonymous"></script>

    <!--CSS-->
    <link rel="stylesheet" href="{{ asset('css/blog_post.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mercadinho.css') }}">
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ asset('css/event.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carroussel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/root.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sign.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/userManagement.css') }}">


    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Quicksand:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JS -->
    <!--<script src="../scripts/carroussel.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <style>
        #saltar {
            position: absolute;
            left: -10000px;
            top: -10000px;
        }

        #conteudos:focus,
        #conteudos:active {
            outline: none;
        }

    </style>

</head>

@if ($title == 'Login' || $title == 'Register')

    <body class="Sign-page">
    @else

        <body>
@endif
<div id="saltar">
    <a href="#conteudos">Saltar para os conteúdos</a>
</div>

<header class="px-2 px-xl-0 w-100">
    {{-- TODO NAVBAR --}}
    @include('partials.navbar')
</header>


{{-- PAGE CONTENT HERE --}}
@yield('content')


</main>
<footer class="py-4 d-flex w-100 bg-secondary text-white justify-content-center align-items-center">
    <div
        class="footer-content w-100 container-default d-flex flex-column gap-4 gap-md-0 flex-md-row justify-content-between align-items-center">
        &copy; 2021 Sustainlbaw
        <div>
            <button class="btn btn-dark"><i class="fab fa-instagram"></i></button>
            <button class="btn btn-dark"><i class="fab fa-facebook-f"></i></button>
            <button class="btn btn-dark"><i class="fab fa-youtube"></i></button>
        </div>
    </div>
</footer>

</body>

</html>
