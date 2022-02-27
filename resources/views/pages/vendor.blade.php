@extends('layouts.app', ['title' => 'Vendor'])

@section('content')

     <main id= "conteudos" tabindex="0" class="container-default px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">

        <a href="/market" class="go-back"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Voltar</a>

        <div id="vendor-page">
            <section class="vendor-section">
                <div class="row">
                    <!-- col-sm-6 col-lg-3 col-md-6 col-xs-12 -->
                    <div class="vendorImg col-lg-6 col-md-6 col-xs-12">
                        <img src="{{ url('storage/images/' . $vendor->image_path) }}" alt="{{ $vendor->image_path }}">
                    </div>
                    <section class="vendorInformation col-lg-6 col-md-6 col-xs-12">
                        <h2>{{ $vendor->name }}</h2>
                        <p>
                            <i class="fa fa-map-marker-alt mr-1 mb-2"></i>
                            {{ $vendor->address . ', ' . $vendor->zip_code }}
                        </p>
                        <p class="fw-bold mb-2">
                            &nbsp;&nbsp;&nbsp;
                            {{ $vendor->county . ', ' . $vendor->parish }}
                        </p>
                        <p>
                            <i class="fa fa-suitcase mr-1 mb-3"></i>
                            {{ $vendor->job }}
                        </p>

                        <h6 id="vendor-description-title">Descrição:</h6>
                        <p id="vendor-description">{{ $vendor->description }}
                        </p>
                    </section>
                </div>
            </section>
            <section id="products">
                <div class="row">
                    @include('partials.market.products',['products' => $products])
                </div>
            </section>
        </div>
    </main>

@endsection
