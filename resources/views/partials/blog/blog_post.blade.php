<div id="{{ 'blog_' . $post->blog_post_id }}" class="blog-post">
    <a href="{{ '/blog/' . $post->blog_post_id }}" class="w-100 text-decoration-none">
        <img src="{{ url('storage/images/' . $post->image_path) }}" alt="{{ $post->title }}">
        <div class="blog-post-content">
            <div>
                <span class="blog-post-category">
                    @for ($i = 0; $i < sizeof($post->categories); $i++)
                        {{ $post->categories[$i]->name . ' ' }}
                        @if ($i != sizeof($post->categories) - 1)
                            &middot;{{ ' ' }}
                        @endif
                    @endfor
                </span>
                <h4 class="blog-post-title">{{ $post->title }}</h4>
            </div>
            <h6 class="blog-post-author">{{ $post->author }}</h6>
        </div>
    </a>

    @if (Auth::check() && Auth::user()->isEditor())
        <div class="post-settings delete">
            <a href="{{ '/blog/' . $post->blog_post_id . '/edit' }}" class="btn btn-dark rounded-circle"><i
                    class="fas fa-pencil-alt"></i></a>
            <button class="btn btn-danger rounded-circle" data-toggle="modal"
                data-target="{{ '#modalDeleteItem' . $post->blog_post_id }}"><i class="fas fa-times"></i></a>
        </div>
    @endif


</div>

<div class="modal fade" id="{{ 'modalDeleteItem' . $post->blog_post_id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Tens a certeza que quer eliminar este item?
                </h4>
                <input type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <input type="submit" data-dismiss="modal" id="{{ 'delete-button' . $post->blog_post_id }}"
                    class="btn btn-light" name="submit" value="Cancelar" />
                <input type="submit" onclick="deletePost({{ $post->blog_post_id }})" class="btn btn-danger"
                    name="submit" value="Eliminar" />
            </div>
        </div>
    </div>


</div>
