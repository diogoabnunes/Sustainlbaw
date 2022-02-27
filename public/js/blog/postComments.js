function addComment(event) {
    event.preventDefault();
    let content = event.target.children[0].value

    if (content != null && content != "") {
        sendAjaxRequest('post', '/blog/comment/', { blog_post_id: event.target.getAttribute('blog-post-id'), content: content }, commentPostHandler);
    }
    event.target.children[0].value = null
}

function commentPostHandler() {
    //if (this.status != 200) window.location = '/';
    let data = JSON.parse(this.responseText);

    let commentsContainer = document.querySelector('#blog-post-comments');

    let newComment = document.createElement('div');
    newComment.setAttribute('data-id', data.comment.comment_id);
    newComment.classList.add('comment');
    newComment.classList.add('w-100');

    if (data.user.image_path == null) {
        data.user.image_path = "../assets/fotoperfil.jpeg";
    }

    let innerContent = `<div class="d-flex flex-row gap-2">
    <div class="card w-100 p-3">
      <div class="d-flex flex-row justify-content-between align-items-center mb-2">
        <div class="d-flex flex-row gap-2 justify-content-start align-items-center">
          <img class="comment-user-image rounded-circle" src="../storage/images/${data.user.image_path}" alt="${data.user.image_path}" height="40" width="40">
          <span class="comment-user fw-bold">${data.user.first_name} ${data.user.last_name}</span>
        </div>
        <div class="dropdown">
        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-lg-end me-2">
            <li>
                <a class="dropdown-item d-flex edit-comment" href="#">Editar</a>
            </li>
            <li>
                <a class="dropdown-item d-flex delete-comment" href="#">Eliminar</a>
            </li>
        </ul>
    </div>
      </div>
      <p class="comment-content">${data.comment.content}</p>
      <span class="comment-date">${data.formattedDate}</span>
    </div>
  </div>`;


    newComment.innerHTML = innerContent;
    commentsContainer.insertBefore(newComment, commentsContainer.firstChild);

    addDeleteCommentListener(newComment);
    addEditCommentListener(newComment);
}