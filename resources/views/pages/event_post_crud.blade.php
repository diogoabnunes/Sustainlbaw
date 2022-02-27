@extends('layouts.app', ['title' => 'Event CRUD'])

@section('content')

    <main id="conteudos" tabindex="0"
        class="container w-100 px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">
        @if (@isset($_GET['error']))
            <div class="alert alert-danger alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Dados Inválidos...</strong>
            </div>
        @endif
        <a href="/events" class="go-back"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Voltar</a>


        @if (@isset($event))
            <h1 class="pb-2">Editar Evento</h1>
            <form method="post" action="{{ '/event/' . $event->event_id }}" id="event_crud_page"
                enctype="multipart/form-data" class="form-page-new w-100">
                <input type="hidden" name="_method" value="PUT">
            @else
                <h1 class="pb-2">Adicionar Evento</h1>
                <form method="post" action="/event" id="event_crud_page" enctype="multipart/form-data"
                    class="form-page-new w-100">
        @endif
        {{ csrf_field() }}

        @if ($errors->has('start_date') || $errors->has('end_date'))
            <div class="alert alert-danger alert-dismissible">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                Insere uma data válida...
            </div>
        @endif
        <div class="row">

            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="form-group mb-3">
                    <label for="eventTitle">Título: </label>
                    <label class="text-danger">*</label>
                    <input type="text" name="name" value="{{ $event->name ?? '' }}" class="form-control" id="eventTítulo"
                        placeholder="Título" required="true">
                </div>
                <label for="category-select " class="form-label">Categoria: </label>
                <label class="text-danger">*</label>
                <select id="category-select" class="form-select mb-3" aria-label="Default select example" required="true">
                    @if (@isset($event->categories))
                        <option value="" disabled>Escolher categoria</option>
                    @else
                        <option value="" disabled selected>Escolher categoria</option>
                    @endif
                    @foreach ($categories as $category)
                        @if ($category->found == true)
                            <option selected value="{{ $category->category_id }}">{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
                <div class="form-group d-flex flex-row gap-2 mb-3">
                    @if ($errors->has('start_date') || $errors->has('end_date'))
                        <div class="alert alert-danger alert-dismissible">
                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                            Insere uma data válida...
                        </div>
                    @endif

                    <div class="w-100">
                        <label for="eventDate">Data Início: </label>
                        <label class="text-danger">*</label>
                        @if (@isset($event))
                            <input type="datetime-local" name="start_date"
                                value="{{ date_format(new DateTime($event->start_date), 'Y-m-d\TH:i') ?? '' }}"
                                class="form-control" id="start_date" name="start_date" required="true">
                        @else
                            <input type="datetime-local" name="start_date" class="form-control" id="start_date"
                                required="true">
                        @endif

                    </div>

                    <div class="w-100">
                        <label for="eventDate">Data Fim: </label>
                        <label class="text-danger">*</label>
                        @if (@isset($event))
                            <input type="datetime-local" name="end_date"
                                value="{{ date_format(new DateTime($event->end_date), 'Y-m-d\TH:i') ?? '' }}"
                                class="form-control" id="end_date" name="end_date" required="true">
                    </div>
                @else
                    <input type="datetime-local" name="end_date" class="form-control" id="end_date" required="true">
                </div>
                @endif


            </div>

            <div class="form-group mb-3 d-flex flex-column">

                <div class="form-group mb-3 d-flex flex-column">
                    <label for="eventPrice">Distrito: <span class="text-danger">*<span></label>
                    <select id="select-district" class="w-100 form-select" aria-label="Default select example" required>

                        @if (@isset($event->district))
                            <option disabled>Selecione o distrito</option>
                        @else
                            <option selected disabled>Selecione o distrito</option>
                        @endif

                        @foreach ($districts as $district)
                            @if (@isset($event) && $district->district == $event->district)
                                <option selected value="{{ $event->district }}">{{ $event->district }} </option>
                            @else
                                <option value="{{ $district->district }}">{{ $district->district }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-start align-items-center gap-2">
                    <div class="w-100">
                        <label for="eventPrice">Concelho: </label>
                        <label class="text-danger">*</label>
                        <select id="select-county" class="w-100 form-select" aria-label="Default select example" required>
                            <option selected disabled>Selecione primeiro o distrito</option>

                            @if (@isset($event->county))
                                <option disabled>Selecione o concelho</option>
                                @foreach ($counties as $county)
                                    @if (@isset($event) && $county->county == $event->county)
                                        <option selected value="{{ $event->county }}">{{ $event->county }} </option>
                                    @else
                                        <option value="{{ $county->county }}">{{ $county->county }}</option>
                                    @endif
                                @endforeach
                            @endif


                        </select>
                    </div>


                    <div class="w-100">
                        @if ($errors->has('zip_code'))
                            <div class="alert alert-danger alert-dismissible">
                                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                Insere um código-postal válido...
                            </div>
                        @endif
                        <label for="eventPrice">Código Postal: <span class="text-danger">*<span></label>
                        <input type="text" name="zip_code" value="{{ $event->zip_code ?? '' }}" class="form-control"
                            id="zip_code" placeholder="Código Postal" pattern="^\d{4}(?:[-\s]\d{3})?$"
                            title="Digite o código postal no formato XXXX-XXX" required>
                    </div>
                </div>
            </div>
            <div class="form-group mb-3 d-flex flex-column">
                <label for="select-parish">Freguesia: <span class="text-danger">*<span></label>
                <select id="select-parish" name="parish" class="w-100 form-select" aria-label="Default select example"
                    required>
                    <option disabled selected>Selecione primeiro o distrito</option>

                    @if (@isset($event->parish))
                        <option disabled>Selecione o distrito</option>
                        @foreach ($parishes as $parish)
                            @if (@isset($event) && $parish->parish == $event->parish)
                                <option selected value="{{ $parish->dcp_id }}">{{ $parish->parish }} </option>
                            @else
                                <option value="{{ $parish->dcp_id }}">{{ $parish->parish }}</option>
                            @endif
                        @endforeach
                    @endif


                </select>
            </div>



            <div class="form-group mb-3 d-flex flex-column">
                <label for="eventPrice">Morada: <span class="text-danger">*<span></label>
                <input type="text" name="address" value="{{ $event->address ?? '' }}" class="form-control" id="address"
                    placeholder="Morada" required>
            </div>




            <div class="form-group mb-3">
                @if ($errors->has('address'))
                    <div class="alert alert-danger alert-dismissible">
                        <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                        Insere uma morada válida...
                    </div>
                @endif

                <label for="eventPrice">Preço: </label>
                <label class="text-danger">*</label>
                <input type="number" name="price" value="{{ $event->price ?? '' }}" min="1" step="any"
                    class="form-control" id="eventJob" placeholder="Preço" required="true">
            </div>

        </div>

        <div class="imageCol mb-3 mt-3 col-lg-6 col-md-6 col-xs-12">


            <div class="image">
                @if ($errors->has('image_path'))
                    <div class="alert alert-danger alert-dismissible">
                        <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                        Insere uma imagem válida...
                    </div>
                @endif
                @if (@isset($event))
                    <label id="upload-label" for="upload-photo"><i id="camera-icon"></i>
                        <input type="file" name="image_path" value="{{ $event->image_path ?? '' }}" id="upload-photo"
                            action=style="display:none" onchange="loadFile(event)" />
                        <img id="display-photo" src="{{ url('storage/images/' . $event->image_path) }}"
                            alt="{{ $event->image_path }}">
                    @else
                        <label id="upload-label" for="upload-photo"><i id="camera-icon" class="fas fa-camera"></i>
                            <input type="file" name="image_path" value="{{ $event->image_path ?? '' }}" id="upload-photo"
                                action=style="display:none" onchange="loadFile(event)" required />
                            <img id="display-photo" src="" alt="Input foto evento" style="display:none;">
                @endif
                </label>
            </div>

            <script>
                var loadFile = function(event) {
                    let output = document.getElementById('display-photo');
                    output.style.display = "block";
                    output.src = URL.createObjectURL(event.target.files[0]);
                    let camera = document.getElementById('camera-icon');
                    camera.style.display = "none";
                };

            </script>
        </div>
        </div>


        <div>
            @if ($errors->has('description'))
                <div class="alert alert-danger alert-dismissible">
                    <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    Erro na descrição do event. :(
                </div>
            @endif
            <label for="exampleFormControlTextarea1" class="form-label">Texto:</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="description"
                rows="10">{{ $event->description ?? '' }}</textarea>
        </div>
        @if (@isset($event))
            <button type="submit" class="btn btn-primary mt-3">Atualizar</button>
        @else
            <button type="submit" class="btn btn-primary mt-3">Adicionar</button>
        @endif

        </form>

        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/events/locations.js') }}"></script>

    </main>

@endsection
