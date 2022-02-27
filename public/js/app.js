function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}

/*SUSTAINLBAW */

function deletePost(id) {
    sendAjaxRequest('delete', '/blog/' + id, null, postDeletedHandler);
}

function deleteEvent(id) {
    sendAjaxRequest('delete', '/event/' + id, null, eventDeletedHandler);
}

function deleteVendor(id) {
    sendAjaxRequest('delete', '/market/' + id, null, vendorDeletedHandler);
}

function postDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('#blog_' + item);
    element.remove();
    modalId = "modalDeleteItem" + item
    closeOneModal(modalId);
}

function eventDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('.event_' + item);
    modalId = "modalDeleteEvent" + item
    closeOneModal(modalId);
    element.remove();
}

function vendorDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('#vendor_' + item);
    modalId = "modalDeleteVendor" + item
    closeOneModal(modalId);
    element.remove();
}


function closeOneModal(modalId) {
    let modal;
    if (modalId instanceof HTMLElement) {
        modal = modalId;
    }
    else {
        modal = document.getElementById(modalId);
    }

    // change state like in hidden modal
    if (modal.classList.contains("show"))
        modal.classList.remove("show");
    modal.setAttribute("aria-hidden", "true");
    modal.setAttribute("style", "display: none");
    document.body.classList = "";
    document.body.style = "";


    // get modal backdrop
    const modalBackdrops = document.getElementsByClassName("modal-backdrop");

    // remove opened modal backdrop
    document.body.removeChild(modalBackdrops[0]);
}





function otherEvents(page) {
    sendAjaxRequest('get', '/events', { 'page': page }, otherEventsHandler);
}

function otherEventsHandler() {

    if (this.status != 200) window.location = '/events';
    let items = JSON.parse(this.responseText);
    console.log(items);

    // let posts = document.querySelectorAll('.blog-post');

    // posts.forEach(post => {
    //     if (!post.classList.contains('blog-add-post'))
    //         post.remove();
    // })

}

/*** */


// function sendItemUpdateRequest() {
//     let item = this.closest('li.item');
//     let id = item.getAttribute('data-id');
//     let checked = item.querySelector('input[type=checkbox]').checked;

//     sendAjaxRequest('post', '/api/item/' + id, { done: checked }, itemUpdatedHandler);
// }

// function sendDeleteItemRequest() {
//     let id = this.closest('li.item').getAttribute('data-id');

//     sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
// }

// function sendCreateItemRequest(event) {
//     let id = this.closest('article').getAttribute('data-id');
//     let description = this.querySelector('input[name=description]').value;

//     if (description != '')
//         sendAjaxRequest('put', '/api/cards/' + id, { description: description }, itemAddedHandler);

//     event.preventDefault();
// }

// function sendDeleteCardRequest(event) {
//     let id = this.closest('article').getAttribute('data-id');

//     sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
// }

// function sendCreateCardRequest(event) {
//     let name = this.querySelector('input[name=name]').value;

//     if (name != '')
//         sendAjaxRequest('put', '/api/cards/', { name: name }, cardAddedHandler);

//     event.preventDefault();
// }

// function itemUpdatedHandler() {
//     let item = JSON.parse(this.responseText);
//     let element = document.querySelector('li.item[data-id="' + item.id + '"]');
//     let input = element.querySelector('input[type=checkbox]');
//     element.checked = item.done == "true";
// }

// function itemAddedHandler() {
//     if (this.status != 200) window.location = '/';
//     let item = JSON.parse(this.responseText);

//     // Create the new item
//     let new_item = createItem(item);

//     // Insert the new item
//     let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
//     let form = card.querySelector('form.new_item');
//     form.previousElementSibling.append(new_item);

//     // Reset the new item form
//     form.querySelector('[type=text]').value = "";
// }

// function itemDeletedHandler() {
//     if (this.status != 200) window.location = '/';
//     let item = JSON.parse(this.responseText);
//     let element = document.querySelector('li.item[data-id="' + item.id + '"]');
//     element.remove();
// }

// function cardDeletedHandler() {
//     if (this.status != 200) window.location = '/';
//     let card = JSON.parse(this.responseText);
//     let article = document.querySelector('article.card[data-id="' + card.id + '"]');
//     article.remove();
// }

// function cardAddedHandler() {
//     if (this.status != 200) window.location = '/';
//     let card = JSON.parse(this.responseText);

//     // Create the new card
//     let new_card = createCard(card);

//     // Reset the new card input
//     let form = document.querySelector('article.card form.new_card');
//     form.querySelector('[type=text]').value = "";

//     // Insert the new card
//     let article = form.parentElement;
//     let section = article.parentElement;
//     section.insertBefore(new_card, article);

//     // Focus on adding an item to the new card
//     new_card.querySelector('[type=text]').focus();
// }

// function createCard(card) {
//     let new_card = document.createElement('article');
//     new_card.classList.add('card');
//     new_card.setAttribute('data-id', card.id);
//     new_card.innerHTML = `

//   <header>
//     <h2><a href="cards/${card.id}">${card.name}</a></h2>
//     <a href="#" class="delete">&#10761;</a>
//   </header>
//   <ul></ul>
//   <form class="new_item">
//     <input name="description" type="text">
//   </form>`;

//     let creator = new_card.querySelector('form.new_item');
//     creator.addEventListener('submit', sendCreateItemRequest);

//     let deleter = new_card.querySelector('header a.delete');
//     deleter.addEventListener('click', sendDeleteCardRequest);

//     return new_card;
// }

// function createItem(item) {
//     let new_item = document.createElement('li');
//     new_item.classList.add('item');
//     new_item.setAttribute('data-id', item.id);
//     new_item.innerHTML = `
//   <label>
//     <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
//   </label>
//   `;

//     new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
//     new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);

//     return new_item;
// }