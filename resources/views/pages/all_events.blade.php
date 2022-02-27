@extends('layouts.app', ['title' => 'Events'])

@section('content')

    @include('partials.events.event_header', ['filter'=>false])

    @if (@isset($category_name))
        <h3>{{ $category_name }}</h3>
        <a href="/events" class="go-back"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Eventos e Experiências</a>

    @endif


    <div id="events-container">

        <section id="all-events" class="m-0">
            <div class="event-row row">
                @foreach ($events as $event)
                    @include('partials.events.event_card',['event'=>$event])
                @endforeach
            </div>
    </div>

    <script src="../js/app.js"></script>
    <script src="../js/events/filterEvents.js"></script>
    </div>


    </main>

@endsection
