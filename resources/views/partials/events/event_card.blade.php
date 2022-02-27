<div id="event-card"
    class="{{ 'col-sm-6 col-lg-4 col-xl-2 col-md-4 col-xs-6 text-decoration-none event_' . $event->event_id }}">
    <!--<span class="event-card-favorite"><i class="fs-5 far fa-heart"></i></span> -->
    <a class="event-card-content text-decoration-none" href="{{ '/event/' . $event->event_id }}">
        <img class="img-fluid" src="{{ url('storage/images/' . $event->image_path) }}"
            alt="{{ $event->image_path }}" />
        <section class="pt-2">
            @if (@isset($inSearch))
                <li class="list-inline-item blog-post-category">
                    Evento</li>
            @else
                <p class="event-card-location">{{ $event->district }} &middot; {{ $event->county }} </p>
            @endIf
            <h6 class="event-card-title">{{ $event->name }}</h6>
            <p class="text-dark"><strong>Desde {{ $event->price }}€</strong> &nbsp;p/pessoa</p>
        </section>
    </a>

    @if (Auth::check() && Auth::user()->isEditor())
        <div class="post-settings">
            <a href="{{ 'event/' . $event->event_id . '/edit' }}" class="btn btn-dark rounded-circle"><i
                    class="fas fa-pencil-alt"></i></a>
            <button class="btn btn-danger rounded-circle" data-toggle="modal"
                data-target="{{ '#modalDeleteEvent' . $event->event_id }}"><i class="fas fa-times"></i></a>
        </div>

    @endif

    <div class="modal fade" id="{{ 'modalDeleteEvent' . $event->event_id }}" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Tens a certeza que queres eliminar este evento?</h4>
                    <input type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <input type="submit" data-dismiss="modal" id="{{ 'delete-button' . $event->event_id }}"
                        class="btn btn-light" name="submit" value="Cancelar" />
                    <input type="submit" onclick="deleteEvent({{ $event->event_id }})" class="btn btn-danger"
                        name="submit" value="Eliminar" />
                </div>
            </div>
        </div>
    </div>
</div>
