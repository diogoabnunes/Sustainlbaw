function deleteCommentListener() {
    let comments = document.querySelectorAll('.comment');
    comments.forEach((comment) => {
        addDeleteCommentListener(comment);
    })
}

function addDeleteCommentListener(comment) {
    let deleteButton = comment.querySelectorAll('.delete-comment');

    if (deleteButton[0] != null) {
        deleteButton[0].addEventListener('click', (e) => {
            e.preventDefault();
            sendAjaxRequest('delete', '/blog/comment', { comment_id: comment.getAttribute('data-id') }, commentDeleteHandler);
        });
    }
}

function commentDeleteHandler() {

    let item = JSON.parse(this.responseText);

    let comments = document.querySelectorAll('.comment');

    comments.forEach(comment => {
        if (comment.getAttribute('data-id') == item.comment_id && item.removed == true) {
            comment.remove();
        }
    })

    //deleteCommentListener();
}

deleteCommentListener();