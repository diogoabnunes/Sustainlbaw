<div data-id="{{ $comment->comment_id }}" class="comment w-100">
    <div class="d-flex flex-row gap-2">
        <div class="card w-100 p-3">
            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                <div class="d-flex flex-row gap-2 justify-content-start align-items-center">
                    @if ($comment->user->active == true)
                        <img class="comment-user-image rounded-circle" src="{{ $comment->user->getAdminAvatar() }}"
                            alt="{{ $comment->user->image_path }}" height="40" width="40">
                        <span
                            class="comment-user fw-bold">{{ $comment->user->first_name . ' ' . $comment->user->last_name }}</span>
                    @else
                        <img class="comment-user-image rounded-circle" src="../assets/fotoperfil.jpeg"
                            alt="fotoperfil.jpeg" height="40" width="40">
                        <span class="comment-user fw-bold">Utilizador Inativo</span>
                    @endif
                </div>

                @if (Auth::user() == $comment->user)
                    <div class="dropdown">
                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end me-2" aria-labelledby="dropdownMenuButton2">
                            <li>
                                <a class="dropdown-item d-flex edit-comment" href="#">Editar</a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex delete-comment" href="#">Eliminar</a>
                            </li>
                        </ul>
                    </div>
                @endif

            </div>
            <p class="comment-content">{{ $comment->content }}</p>
            <span
                class="comment-date">{{ $comment->date->locale('pt')->timezone('Europe/Lisbon')->isoFormat('D MMMM, YYYY | H:mm') }}</span>
        </div>
    </div>
</div>
