@extends('layouts.app', ['title' => 'Market'])

@section('content')

    <main id="conteudos" tabindex="0"
        class="container-default px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">

        <div id="market-container">
            <section id="mercadinho-event">
                <h2 class="pb-2">Mercadinho</h2>
                <img src="../../assets/market.webp" alt="Mercadinho" />
            </section>
            <section id="produtores">

                <div class="w-100 mb-4 d-flex flex-column flex-md-row justify-content-between">
                    <h3>Produtores</h3>
                </div>
                <div class="row ">

                    @if (Auth::check() && Auth::user()->isEditor())
                        <div class="eventcollumns col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a class="vendor-add-post" href="/vendor_crud">
                                <h4><i class="fas fa-plus"></i>&nbsp;Novo produtor</h4>
                            </a>
                        </div>
                    @endif

                    @foreach ($vendors as $vendor)
                        @include('partials.market.vendor_card', ['vendor' => $vendor])
                    @endforeach


                    <div id="blog-load-more"
                        class="pt-5 w-100 d-flex flex-column gap-2 justify-content-center align-items-center">
                        <div class="d-inline-flex flex-row justify-content-center  ">
                            {{ $vendors->links() }}

                        </div>
                    </div>

            </section>
        </div>

        <script src="../js/app.js"></script>
    </main>

@endsection
