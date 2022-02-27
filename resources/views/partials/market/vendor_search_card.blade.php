<div id="event-card" @if ($onlySome) class="{{ 'col-sm-6 col-lg-4 col-xl-4 col-md-4 col-xs-6 text-decoration-none ' . 'event_' . $vendor->vendor_id }}">
@else
    class="{{ 'col-sm-6 col-lg-4 col-xl-2 col-md-4 col-xs-6 text-decoration-none ' . 'event_' . $vendor->vendor_id }}"> @endif <!--<span
    class="event-card-favorite"><i class="fs-5 far fa-heart"></i></span> -->
    <a class="event-card-content text-decoration-none" href="{{ '/market/' . $vendor->vendor_id }}">
        <img class="img-fluid" src="{{ url('storage/images/' . $vendor->image_path) }}"
            alt="{{ $vendor->image_path }}" />
        <section class="pt-2">
            <li class="list-inline-item blog-post-category">
                Produtor</li>
            <h6 class="event-card-title">{{ $vendor->name }}</h6>
            <p class="text-dark"><strong>{{ $vendor->job }}</strong></p>


        </section>
    </a>
    @if (Auth::check() && Auth::user()->isEditor())
        <div class="post-settings">
            <a href="{{ '/market/' . $vendor->vendor_id . '/edit' }}" class="btn btn-dark rounded-circle"><i
                    class="fas fa-pencil-alt"></i></a>
            <button class="btn btn-danger rounded-circle" data-toggle="modal" data-target="#modalDeleteItem"><i
                    class="fas fa-times"></i></a>
        </div>
    @endif
</div>
