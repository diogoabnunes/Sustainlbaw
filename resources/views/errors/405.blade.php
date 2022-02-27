@extends('layouts.app', ['title' => 'Página Inexistente'])

@section('content')
    <main class="container-default w-100 d-flex flex-column justify-content-center align-items-center h-100">
        <div class="d-flex justify-content-center align-items-center d-flex flex-column">
            <h1 class="display-1 fw-bold">Oops! 405</h1>
            <h4 class="fw-bold">Ocorreu um erro no servidor! </h3>
                <h6 class="text-secondary">Essa pagina não foi encontrada...</h6>
                <a class="mt-4 btn btn-primary" href="/">Página Inicial</a>
        </div>
    </main>

@endsection

<style>
    .error-page {
        background-image: url(../assets/signUp_folhas.png);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .error-info {
        padding-top: 15%;
    }

</style>
