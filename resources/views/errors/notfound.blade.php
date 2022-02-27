@extends('layouts.app', ['title' => 'Error page'])

@section('content')
<main class="container-default w-100 d-flex flex-column justify-content-center align-items-center h-100">
    <div class="d-flex justify-content-center align-items-center d-flex flex-column">
        <h1 class="display-1 fw-bold">Página não encontrada...</h1>  
        <h4 class="fw-bold">Ocorreu um erro no servidor! </h3>
        <h6 class="text-secondary">Por favor tente novamente...</h6>
        <a class="mt-4 btn btn-primary" href="/">Página Inicial</a>
    </div>
</main>
      
@endsection