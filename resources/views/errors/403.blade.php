@extends('layouts.app', ['title' => 'Error page'])

@section('content')
<main class="container-default w-100 d-flex flex-column justify-content-center align-items-center h-100">
    <div class="d-flex justify-content-center align-items-center d-flex flex-column">
        <h1 class="display-1 fw-bold">Não autorizado</h1>  
        <h4 class="fw-bold">Não tem acesso a esta funcionalidade! </h3>
        <a class="mt-4 btn btn-primary" href="/">Página Inicial</a>
    </div>
</main>
      
@endsection