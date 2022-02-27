<main
    class="w-100 h-100 container-default px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">
    <div id="events-container" class="w-100">
        <div class="w-100 mb-4 d-flex flex-column flex-md-row justify-content-between">

            @if (!@isset($category_name))
                <h2>Eventos e Experiências</h2>
            @endif

            @if (Auth::check() && Auth::user()->isEditor())
                <a href="event_post_crud"
                    class="btn btn-primary d-flex flex-row align-items-center justify-content-center">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Adicionar Evento
                </a>
            @endif
        </div>

        @if (isset($filter) && !@isset($category_name))
            <div id="event-tabs" class="d-none d-lg-flex">
                <a class="active event-tab" onclick="filterEvent(event)" value="all">Todos</a>
                <a class="event-tab" onclick="filterEvent(event)" value="this_week">Esta semana</a>
                <a class="event-tab" onclick="filterEvent(event)" value="next_week">Na próxima semana</a>
                <a class="event-tab" onclick="filterEvent(event)" value="this_month">Este mês</a>
            </div>

            <select class="form-select btn-outline-secondary mb-4 d-lg-none" onchange="filterEvent(event)"
                aria-label="Default select example">
                <option selected value="all" onselect="filterEvent(event)">Todos</option>
                <option value="next_week" onselect="filterEvent(event)">Na próxima semana</option>
                <option value="this_week" onselect="filterEvent(event)">Esta semana</option>
                <option value="this_month" onselect="filterEvent(event)">Este mês</option>

            </select>
        @endif
