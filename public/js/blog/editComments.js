function editCommentListener() {
    let comments = document.querySelectorAll('.comment');
    comments.forEach((comment) => {
        addEditCommentListener(comment);
    })
}

function addEditCommentListener(comment) {
    let editButton = comment.querySelectorAll('.edit-comment');

    if (editButton[0] != null)
        editButton[0].addEventListener('click', (e) => {
            e.preventDefault();

            let content = comment.querySelectorAll('.comment-content')[0].outerText;
            let user = comment.querySelectorAll('.comment-user')[0].outerText;
            let image_path = comment.querySelectorAll('.comment-user-image')[0].src;
            let blog_post_id = comment.getAttribute('data-id');

            comment.innerHTML = `<div class="d-flex flex-row gap-2">
                    <div class="card w-100 p-3">
                    <div class="d-flex flex-row gap-2 justify-content-start align-items-center mb-2">
                        <img class="rounded-circle" src="${image_path}" alt="${image_path}" height="40" width="40">
                        <span class="fw-bold">${user}</span>
                    </div>
                    <form class="add-comment" onsubmit="editComment(event)" data-id="${blog_post_id}">
                        <input type="text" class="form-control" value="${content}"  required="true">
                    </form>
                    </div>
                </div>`;
        });
}

function editComment(event) {
    event.preventDefault();
    sendAjaxRequest('put', '/blog/comment', { comment_id: event.target.getAttribute('data-id'), content: event.target.children[0].value }, commentEditHandler);
}


function commentEditHandler() {

    let data = JSON.parse(this.responseText);

    let comments = document.querySelectorAll('.comment');


    if (data.comment.user.image_path == null) {
        data.comment.user.image_path = "fotoperfil.jpeg";
    }

    if (data.updated) {
        comments.forEach(comment => {
            if (comment.getAttribute('data-id') == data.comment.comment_id) {
                comment.innerHTML = `<div class="d-flex flex-row gap-2">
                <div class="card w-100 p-3">
                  <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                    <div class="d-flex flex-row gap-2 justify-content-start align-items-center">
                      <img class="comment-user-image rounded-circle" src="../storage/images/${data.comment.user.image_path}" alt="${data.comment.user.image_path}" height="40" width="40">
                      <span class="comment-user fw-bold">${data.comment.user.first_name} ${data.comment.user.last_name}</span>
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

                addEditCommentListener(comment);
                addDeleteCommentListener(comment);
            }
        })
    }
}

editCommentListener();