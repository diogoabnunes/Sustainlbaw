@extends('layouts.app', ['title' => 'Events'])

@section('content')

    <main id= "conteudos" tabindex="0"
        class="w-100 container-default px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start align-self-start w-100">



        <div id="events-container">
            <div class="w-100 mb-4 d-flex flex-column flex-md-row justify-content-between">
                <h2>Resultados de pesquisa</h2>
            </div>

            <div id="search-types" class="d-none d-lg-block mb-4">

                <a data-id="blog" onclick="selectType(event)" id="type-blog" class="type btn btn-outline-secondary">Blog</a>
                <a data-id="events" onclick="selectType(event)" id="type-events"
                    class="type btn btn-outline-secondary">Eventos</a>
                <a data-id="vendors" onclick="selectType(event)" id="type-vendors"
                    class="type btn btn-outline-secondary">Produtores</a>

            </div>

            <div id="events-container w-100">

                <section id="most-recent" class="m-0">

                    <div class="search-container" id="events">
                        <div class="event-row row">
                            <h3>Eventos</h3>
                            @for ($i = 0; $i < count($events); $i++)
                                @include('partials.events.event_card',['event'=>$events[$i],'inSearch'=>true])
                            @endfor
                        </div>
                    </div>

                    <div class="search-container" id="blog">
                        <div class="event-row row">
                            <h3>Blog</h3>
                            @for ($i = 0; $i < count($blog_posts); $i++)
                                @include('partials.blog.blog_search_card',['blog_post'=>$blog_posts[$i]])
                            @endfor
                        </div>
                    </div>

                    <div class="search-container" id="vendors">
                        <div class="event-row row">
                            <h3>Produtores</h3>
                            @for ($i = 0; $i < count($vendors); $i++)
                                @include('partials.market.vendor_search_card',['vendor'=>$vendors[$i],'onlySome' =>
                                $onlySome])
                            @endfor
                        </div>
                    </div>


            </div>

        </div>






        <script src="../js/search/filterSearch.js"></script>

    </main>

@endsection
