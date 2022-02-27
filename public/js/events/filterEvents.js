function filterEvent(event) {

    let value;
    if (event.target.value != null) {
        value = event.target.value;
    } else {
        value = event.target.getAttribute("value");
        event.target.classList.add("active");


        let tabs = document.querySelectorAll(".event-tab");
        tabs.forEach(tab => {
            if (tab.classList.contains('active')) {
                tab.classList.remove('active');
            }
        })
    }

    sendAjaxRequest('get', 'api/events/' + value, 'null', filterEventHandler);
}

function filterEventHandler() {

    let data = JSON.parse(this.responseText);
    let eventsContainer = document.querySelector('.event-row');
    let events = document.querySelectorAll('.event-row #event-card')


    events.forEach(event => event.remove())

    data.events.forEach(event => {
        let newEvent = document.createElement('div');
        newEvent.id = "event-card";
        newEvent.classList.add('col-sm-6', 'col-lg-4', 'col-xl-2', 'col-md-4', 'col-xs-6', 'text-decoration-none', `event_${event.event_id}`);


        newEvent.innerHTML = `<a class="event-card-content text-decoration-none" href="/event/${event.event_id}">
                <img class="img-fluid" src="/storage/images/${event.image_path}"
                    alt="${event.title}" />
                <section class="pt-2">
                    
                    <h6 class="event-card-title">${event.name}</h6>
                    <p class="text-dark"><strong>Desde ${event.price}€</strong> &nbsp;p/pessoa</p>
                </section>
            </a>
            <div class="modal fade" id="modalDeleteEvent${event.event_id}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h4 class="modal-title w-100 font-weight-bold">Tens a certeza que queres eliminar este evento?</h4>
                            <input type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        </div>
                        <div class="modal-footer d-flex justify-content-end">
                            <form id="delete-form${event.event_id}" method="POST" action="">
                                <input type="submit" id="delete-button${event.event_id}" class="btn btn-light"
                                    name="submit" value="Cancelar" />
                            </form>
                            <input type="submit" onclick="deleteEvent(${event.event_id})" class="btn btn-danger"
                                name="submit" value="Eliminar" />
                        </div>
                    </div>
                </div>
            </div>`;

        if (data.editor) {
            newEvent.innerHTML += `<div class="post-settings">
                    <a href="/event/${event.event_id}/edit" class="btn btn-dark rounded-circle"><i
                            class="fas fa-pencil-alt"></i></a>
                    <button class="btn btn-danger rounded-circle" data-toggle="modal" data-target="#modalDeleteItem"><i
                            class="fas fa-times"></i></a>
                </div>`;
        }
        eventsContainer.appendChild(newEvent)

    })
}