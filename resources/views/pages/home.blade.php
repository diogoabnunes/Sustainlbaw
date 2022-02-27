@extends('layouts.app', ['title' => 'Homepage'])

@section('content')



    <div class="w-100 d-flex flex-column justify-content-center align-items-center">

        @if (@isset($_GET['messagelogin']))
            <div class="alert alert-success alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Successo!</strong> Login efetuado :D
            </div>
        @endif
        @if (@isset($_GET['messageregist']))
            <div class="alert alert-success alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Successo!</strong> Registo efetuado :D
            </div>
        @endif
        @if (@isset($_GET['accountDeleted']))
            <div class="alert alert-danger alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                A tua conta foi eliminada.
            </div>
        @endif

        @if (@isset($_GET['passwordRecovery']))
            <div class="alert alert-success alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                Foi enviado um email para recuperar a palavra-passe
            </div>
        @endif

        @if (@isset($_GET['wrongPassword']))
            <div class="alert alert-danger alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                Password errada a tentar eliminar conta.
            </div>
        @endif

        @if (@isset($_GET['passwordReset']))
            <div class="alert alert-success alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                A sua password foi alterada com sucesso
            </div>
        @endif
        <div id="banner">
            <div id="banner-info">
                <div id="banner-info-container">
                    <h1 id="banner-title">O Sustainlbaw está à tua espera!</h1>
                    @if (!Auth::check())
                        <p class="text-light fs-4">Regista-te e junta-te à nossa comunidade!</p>
                    @else
                        <p class="text-light fs-4">Bem-vindo à nossa comunidade!</p>
                    @endif
                    <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start gap-2">
                        <a href="/events" class="btn btn-lg btn-secondary"><i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;Os
                            nossos eventos</a>
                        @if (!Auth::check())
                            <a href="{{ route('register') }}" class="btn btn-lg btn-primary">Regista-te</a>
                        @else
                            <a href="/blog" class="btn btn-lg btn-primary">Visita o Blog!</a>

                        @endif

                    </div>
                    <a href="#mission-cards-container" id="banner-arrow">
                        <span class="text-light">Faz scroll para ver mais </span>
                        <i class="text-light fs-2 fas fa-chevron-down"></i>
                    </a>
                </div>


            </div>
        </div>

        <div class="mission-container">
            <div id="mission-cards-container">
                <div class="mission-card">
                    <div class="mission-card-info">
                        <i class="fs-1 fas fa-users"></i>
                        <h4 class="text-secondary">Comunidade</h4>
                        <p>Fomentar o espírito de comunidade e entre-ajuda.</p>
                    </div>
                </div>
                <div class="mission-card">
                    <div class="mission-card-info">
                        <i class="fs-1 fas fa-seedling"></i>
                        <h4 class="text-secondary">Sustentabilidade</h4>
                        <p>Inspirar práticas sustentáveis e saudáveis em harmonia com a natureza.</p>
                    </div>
                </div>
                <div class="mission-card">
                    <div class="mission-card-info">
                        <i class="fs-1 fas fa-flag"></i>
                        <h4 class="text-secondary">Identidade e Inovação</h4>
                        <p>Preservar a nossa identidade com um bom toque de inovação.</p>
                    </div>
                </div>
            </div>
        </div>

        <main id="conteudos" tabindex="0"
            class="container-default w-100 px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">

            <div class="story-block">
                <img src="../assets/market.jpeg" alt="Mercadinho">
                <div class="story-info">
                    <h2>O Mercadinho</h2>
                    <p>O nosso mercado semanal procura trazer uma experiência diferente aos consumidores e produtores,
                        criando relações duradoras. Compra local e conhece o teu alimento.</p>
                    <a href="/market" class="btn btn-primary"><i class="fas fa-shopping-basket"></i>&nbsp;&nbsp;Descobre
                        mais aqui</a>
                </div>

            </div>

            <h2 class="align-self-center mt-4 mb-4">Os nossos parceiros</h2>
            <div id="partners-container">
                <div class="partner"><img src="../assets/feup.jpg" alt="feup.jpg"></div>
                <div class="partner"><img src="../assets/csfeup.jpg" alt="csfeup.jpg"></div>
                <div class="partner"><img src="../assets/rcs.jpg" alt="rcs.jpg"></div>
                <div class="partner"><img src="../assets/celeiro.png" alt="celeiro.png"></div>
                <div class="partner"><img src="../assets/togoodtogo.png" alt="togoodtogo.png"></div>
            </div>
        </main>
    </div>

@endsection
