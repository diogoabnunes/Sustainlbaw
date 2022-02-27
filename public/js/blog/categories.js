function selectCategory(event) {

    event.preventDefault();

    if (!event.target.classList.contains('active')) {
        event.target.classList.add('active');
        event.target.style.color = "white";
        event.target.style.background = "#534d4e"
    } else {
        event.target.classList.remove('active');
        event.target.style.color = "#534d4e";
        event.target.style.background = "white"
    }

    let activeCategories = getActiveCategories()

    if (activeCategories != null) {
        let button = document.getElementById('all_categories');
        button.style.color = "#534d4e";
        button.style.background = "white"
    }

    sendAjaxRequest('get', '/blog/categories/' + activeCategories, null, blogCategoryGetHandler);
}

function getActiveCategories() {
    let categories = document.querySelectorAll('.category');

    activeCategories = []

    categories.forEach(category => {
        if (category.classList.contains('active')) {
            activeCategories.push(category.getAttribute('data-id'))
        }
    })

    return activeCategories;
}

function blogCategoryGetHandler() {

    if (this.status != 200) window.location = '/blog';


    let items = JSON.parse(this.responseText);
    console.log(items)
    let posts = document.querySelectorAll('.blog-post');

    posts.forEach(post => {
        if (!post.classList.contains('blog-add-post'))
            post.remove();
    })


    postsContainer = document.querySelector('#blog-posts-container');
    selectedPosts = [];

    items['posts'].forEach(item => {

        newPost = document.createElement('div');
        newPost.id = `blog_${item.blog_post_id}`;
        newPost.classList.add('blog-post');


        let categories = "";
        for (let i = 0; i < item.categories.length; i++) {
            categories += item.categories[i].name
            if (i != item.categories.length - 1)
                categories += " &middot; ";
        }

        newPost.innerHTML = `<a href="/blog/${item.blog_post_id}" class="w-100 text-decoration-none">
            <img src="storage/images/${item.image_path}" alt="${item.title}"/>
            <div class="blog-post-content">
                <div>
                    <span class="blog-post-category">${categories}</span>
                    <h4 class="blog-post-title">${item.title}</h4>
                </div>
                <h6 class="blog-post-author">${item.author}</h6>
            </div>
        </a>`;
        if (items.editor) {
            newPost.innerHTML += `<div class="post-settings">
            <a href="/blog/${item.blog_post_id}/edit" class="btn btn-dark rounded-circle"><i
                    class="fas fa-pencil-alt"></i></a>
            <button class="btn btn-danger rounded-circle" data-toggle="modal" data-target="#modalDeleteItem"><i
                    class="fas fa-times"></i></a>
        </div>

        <div class="post-settings delete">
            <a href="/blog/${item.blog_post_id}/edit" class="btn btn-dark rounded-circle"><i
                    class="fas fa-pencil-alt"></i></a>
            <button class="btn btn-danger rounded-circle" data-toggle="modal" data-target="#modalDeleteItem${item.blog_post_id}"><i
                    class="fas fa-times"></i></a>
        </div>`;
        }



        newPost.innerHTML += `
    
    <div class="modal fade" id="modalDeleteItem${item.blog_post_id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Tens a certeza que quer eliminar este item?
                    </h4>
                    <input type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <form id="delete-form${item.blog_post_id}"method="POST"action="">
                        <input type="submit" id="delete-button${item.blog_post_id}" class="btn btn-light" name="submit" value="Cancelar" />
                    </form>
                    <input type="submit" onclick="deletePost(${item.blog_post_id})" class="btn btn-danger" name="submit" value="Eliminar" />
                </div>
            </div>
        </div>
    
       
    </div>
    
    </div>`;


        postsContainer.append(newPost);
    });
}