@extends('layouts.app', ['title' => 'Vendor CRUD'])

@section('content')

    <main id= "conteudos" tabindex="0" class="container px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">
        @if (@isset($_GET['error']))
            <div class="alert alert-danger alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Não foi possível criar evento...</strong> Tenta novamente.
            </div>
        @endif

        @if (@isset($_GET['errorEdit']))
            <div class="alert alert-danger alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Não foi possível editar evento...</strong> Tenta novamente.
            </div>
        @endif

        <a href="/market" class="go-back"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Voltar</a>


        @if (@isset($vendor))
            <form method="post" action="{{ '/market/' . $vendor->vendor_id }}" id="vendor_crud"
                enctype="multipart/form-data" class="form-page-new w-100">
                <input type="hidden" name="_method" value="PUT">
            @else
                <form method="post" action="/market" id="vendor_crud" enctype="multipart/form-data"
                    class="form-page-new w-100">
        @endif

        {{ csrf_field() }}



        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                @if (@isset($vendor))
                    <h1 class="pb-2">Editar Produtor</h1>
                @else
                    <h1 class="pb-2">Adicionar Produtor</h1>
                @endif
                <div class="mb-3">
                    @if ($errors->has('name'))
                        <div class="alert alert-danger alert-dismissible">
                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                            Insere um nome válido...
                        </div>
                    @endif
                    <label for="title" class="form-label">Produtor: </label>
                    <label class="text-danger">*</label>
                    <input type="text" name="name" value="{{ $vendor->name ?? '' }}" class="form-control" id="author"
                        aria-describedby="author" required="true">
                </div>
                <div class="mb-3">
                    @if ($errors->has('job'))
                        <div class="alert alert-danger alert-dismissible">
                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                            Insere uma profissão válida...
                        </div>
                    @endif

                    <label for="Profissão" class="form-label">Profissão: </label>
                    <label class="text-danger">*</label>
                    <input type="text" name="job" value="{{ $vendor->job ?? '' }}" class="form-control" id="Profissão"
                        aria-describedby="Profissão" required="true">
                </div>

                <label for="eventPrice">Distrito: <span class="text-danger">*<span></label>
                <select id="select-district" class="w-100 form-select" aria-label="Default select example" required>

                    @if (@isset($vendor->district))
                        <option disabled>Selecione o distrito</option>
                    @else
                        <option selected disabled>Selecione o distrito</option>
                    @endif

                    @foreach ($districts as $district)
                        @if (@isset($vendor) && $district->district == $vendor->district)
                            <option selected value="{{ $vendor->district }}">{{ $vendor->district }} </option>
                        @else
                            <option value="{{ $district->district }}">{{ $district->district }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="imageCol col-lg-6 col-md-6 col-xs-12">

                <div class="image">
                    @if ($errors->has('image_path'))
                        <div class="alert alert-danger alert-dismissible">
                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                            Insere uma foto...
                        </div>
                    @endif

                    @if (@isset($vendor))
                        <label id="upload-label" for="upload-photo"><i id="camera-icon"></i>
                            <input type="file" name="image_path" value="{{ $vendor->image_path ?? '' }}" id="upload-photo"
                                action=style="display:none" onchange="loadFile(event)" />
                            <img id="display-photo" src="{{ url('storage/images/' . $vendor->image_path) }}"
                                alt="{{ $vendor->image_path }}">
                        @else
                            <label id="upload-label" for="upload-photo"><i id="camera-icon" class="fas fa-camera"></i>
                                <input type="file" name="image_path" value="{{ $vendor->image_path ?? '' }}"
                                    id="upload-photo" action=style="display:none" onchange="loadFile(event)" required />
                                <img id="display-photo" src="" alt="Foto Vendor" style="display:none;">
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

        <div class="form-group mb-3 d-flex flex-column">

            <div class="d-flex justify-content-start align-items-center gap-2">

                <div class="w-100">
                    <label for="eventPrice">Concelho:</label>
                    <label class="text-danger">*</label>
                    <select id="select-county" class="w-100 form-select" aria-label="Default select example" required>
                        <option selected disabled>Selecione primeiro o distrito</option>

                        @if (@isset($vendor->county))
                            <option disabled>Selecione o concelho</option>
                            @foreach ($counties as $county)
                                @if (@isset($vendor) && $county->county == $vendor->county)
                                    <option selected value="{{ $vendor->county }}">{{ $vendor->county }} </option>
                                @else
                                    <option value="{{ $county->county }}">{{ $county->county }}</option>
                                @endif
                            @endforeach
                        @endif


                    </select>
                </div>


                <div class="w-100">
                    <label for="eventPrice">Código Postal: <span class="text-danger">*<span></label>
                    <input type="text" name="zip_code" value="{{ $vendor->zip_code ?? '' }}" class="form-control"
                        id="zip_code" placeholder="Código Postal" pattern="^\d{4}(?:[-\s]\d{3})?$"
                        title="Digite o código postal no formato XXXX-XXX" required>
                </div>

                <div class="w-100">
                    <label for="select-parish">Freguesia: <span class="text-danger">*<span></label>
                    <select id="select-parish" name="parish" class="w-100 form-select" aria-label="Default select example"
                        required>
                        <option disabled selected>Selecione primeiro o distrito</option>

                        @if (@isset($vendor->parish))
                            <option disabled>Selecione o distrito</option>
                            @foreach ($parishes as $parish)
                                @if (@isset($vendor) && $parish->parish == $vendor->parish)
                                    <option selected value="{{ $parish->dcp_id }}">{{ $parish->parish }} </option>
                                @else
                                    <option value="{{ $parish->dcp_id }}">{{ $parish->parish }}</option>
                                @endif
                            @endforeach
                        @endif


                    </select>
                </div>
            </div>

        </div>





        <div class="form-group mb-3 d-flex flex-column">
            <label for="eventPrice">Morada: <span class="text-danger">*<span></label>
            <input type="text" name="address" value="{{ $vendor->address ?? '' }}" class="form-control" id="address"
                placeholder="Morada" required>
        </div>
        </div>

        <div class="mb-3">
            @if ($errors->has('description'))
                <div class="alert alert-danger alert-dismissible">
                    <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    Erro na descrição do vendor. :(
                </div>
            @endif
            <label for="exampleFormControlTextarea1" class="form-label">Texto:</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="description"
                rows="10">{{ $vendor->description ?? '' }}</textarea>
        </div>

        @if (@isset($vendor))
            <button type="submit" class="btn btn-primary">Atualizar</button>
        @else
            <button type="submit" class="btn btn-primary">Adicionar</button>
        @endif
        </form>

        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/events/locations.js') }}"></script>

    </main>

@endsection
