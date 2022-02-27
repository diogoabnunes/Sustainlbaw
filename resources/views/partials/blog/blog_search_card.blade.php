<div id="event-card"
    class="{{ 'col-sm-6 col-lg-4 col-xl-2 col-md-4 col-xs-6 text-decoration-none ' . 'event_' . $blog_post->blog_post_id }}">
    <!--<span class="event-card-favorite"><i class="fs-5 far fa-heart"></i></span> -->
    <a class="event-card-content text-decoration-none" href="{{ '/event/' . $blog_post->blog_post_id }}">
        <img class="img-fluid" src="{{ url('storage/images/' . $blog_post->image_path) }}"
            alt="{{ $blog_post->image_path }}" />
        <section class="pt-2">
            <li class="list-inline-item blog-post-category">
                Blog</li>
            <h6 class="event-card-title">{{ $blog_post->title }}</h6>
            <p class="text-dark"><strong>{{ $blog_post->author }}</strong></p>


        </section>
    </a>
    @if (Auth::check() && Auth::user()->isEditor())

        <div class="post-settings">
            <a href="{{ '/blog/' . $blog_post->blog_post_id . '/edit' }}" class="btn btn-dark rounded-circle"><i
                    class="fas fa-pencil-alt"></i></a>
            <button class="btn btn-danger rounded-circle" data-toggle="modal" data-target="#modalDeleteItem"><i
                    class="fas fa-times"></i></a>
        </div>

        <div class="post-settings delete">
            <a href="{{ '/blog/' . $blog_post->blog_post_id . '/edit' }}" class="btn btn-dark rounded-circle"><i
                    class="fas fa-pencil-alt"></i></a>
            <button class="btn btn-danger rounded-circle" data-toggle="modal"
                data-target="{{ '#modalDeleteItem' . $blog_post->blog_post_id }}"><i class="fas fa-times"></i></a>
        </div>
    @endif
</div>
<div class="modal fade" id="{{ 'modalDeleteItem' . $blog_post->blog_post_id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Tens a certeza que quer eliminar este item?
                </h4>
                <input type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <form id="{{ 'delete-form' . $blog_post->blog_post_id }}" method="POST" action="">
                    <input type="submit" id="{{ 'delete-button' . $blog_post->blog_post_id }}" class="btn btn-light"
                        name="submit" value="Cancelar" />
                </form>
                <input type="submit" onclick="deletePost({{ $blog_post->blog_post_id }})" class="btn btn-danger"
                    name="submit" value="Eliminar" />
            </div>
        </div>
    </div>


</div>
