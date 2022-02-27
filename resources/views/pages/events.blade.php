@extends('layouts.app', ['title' => 'Events'])

@section('content')

    @include('partials.events.event_header')
    <section id="most-recent" class="mt-0">
        <div class="d-flex justify-content-between">
            <h3 class="col align-self-center m-0">Próximos eventos</h3>
        </div>
        <div class="event-row row">
            @for ($i = 0; $i < 6; $i++)
                @include('partials.events.event_card',['event'=>$events[$i]])
            @endfor

        </div>
    </section>


    @include('partials.events.categories', ['categories' => $categories])

    @include('partials.events.market_card')



    <section id="most-popular">
        <div class="d-flex justify-content-between">
            <h3 class="col align-self-center m-0">Mais eventos</h3>
        </div>
        <div class="event-row row">
            @for ($i = 6; $i < count($events); $i++)
                @include('partials.events.event_card',['event'=>$events[$i]])
            @endfor
        </div>

        <div id="blog-load-more" class="pt-5 w-100 d-flex flex-column gap-2 justify-content-center align-items-center">

            <a href="/all_events" class="btn btn-outline-secondary">Ver mais</a>
        </div>
        </div>

        <script src="../js/app.js"></script>

        </main>

    @endsection
